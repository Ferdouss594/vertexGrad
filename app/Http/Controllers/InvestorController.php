<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investor;
use App\Models\InvestorNote;
use App\Models\InvestorFile;
use App\Models\InvestorActivity;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvestorRequest;
use App\Http\Requests\UpdateInvestorRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvestorsImport;
use App\Exports\InvestorsExport;

class InvestorController extends Controller
{
    // =================== قائمة المستثمرين ===================
  public function index(Request $request)
{
    // استعلام من جدول users مباشرة للأشخاص الذين role = 'Investor'
    $query = User::where('role', 'Investor');

    // البحث
    if ($request->filled('search')) {
        $s = $request->search;
        $query->where(function($q) use ($s){
            $q->where('name','like',"%{$s}%")
              ->orWhere('email','like',"%{$s}%")
              ->orWhere('username','like',"%{$s}%");
        });
    }

    // التصفية حسب المدينة أو الحالة
    if ($request->filled('city')) $query->where('city', $request->city);
    if ($request->filled('status')) $query->where('status', $request->status);

    // ترتيب
    $sortBy = $request->get('sort_by','created_at');
    $sortDir = $request->get('sort_dir','desc');
    $investors = $query->orderBy($sortBy, $sortDir)->paginate(15)->withQueryString();

    // إحصائيات بدون deleted_at
    $stats = [
        'total' => User::where('role','Investor')->count(),
        'active' => User::where('role','Investor')->where('status','active')->count(),
        'inactive' => User::where('role','Investor')->where('status','inactive')->count(),
        'budget' => Investor::sum('budget'), // من جدول investors
        'archived' => 0, // لأنه لا يوجد deleted_at
    ];

    return view('investors.index', compact('investors','stats'));
}


    // =================== صفحة إضافة مستثمر ===================
    public function create()
    {
        return view('investors.create');
    }

    // =================== حفظ مستثمر جديد ===================
    public function store(StoreInvestorRequest $request)
    {
        // تحقق من البريد الإلكتروني
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'البريد الإلكتروني موجود مسبقًا.');
        }

        try {
            DB::transaction(function() use ($request, &$investor) {

                // إنشاء المستخدم
                $user = User::create([
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => 'Investor',
                    'status' => $request->status ?? 'active',
                    'gender' => $request->gender ?? null,
                    'city' => $request->city ?? null,
                    'state' => $request->state ?? null,
                    'profile_image' => $request->profile_image ?? null,
                ]);

                // إنشاء المستثمر
                $investor = Investor::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $request->status ?? 'Active',
                    'company' => $request->company ?? null,
                    'position' => $request->position ?? null,
                    'investment_type' => $request->investment_type ?? null,
                    'budget' => $request->budget ?? null,
                    'source' => $request->source ?? null,
                    'notes' => $request->notes ?? null,
                ]);

                // سجل النشاط
                InvestorActivity::create([
                    'investor_id' => $investor->id,
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'meta' => ['name'=>$investor->name]
                ]);
            });

            return redirect()->route('investors.show', $investor)->with('success','تم إنشاء المستثمر بنجاح.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                return redirect()->back()->withInput()->with('error', 'البريد الإلكتروني موجود مسبقًا أو حدث خطأ في قاعدة البيانات.');
            }
            throw $e; // Re-throw if not a duplicate key error
        }
    }

    // =================== عرض مستثمر ===================
    public function show(Investor $investor)
    {
        $investor->load('user','notes.user','files.uploader','activities.user');
        return view('investors.show', compact('investor'));
    }

    // =================== تعديل مستثمر ===================
    public function edit(Investor $investor)
    {
        return view('investors.edit', compact('investor'));
    }

    // =================== تحديث مستثمر ===================
    public function update(UpdateInvestorRequest $request, Investor $investor)
    {
        $investor->update($request->validated());

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'meta' => ['updated_fields' => array_keys($request->validated())]
        ]);

        return redirect()->route('investors.show',$investor)->with('success','تم تحديث المستثمر.');
    }

    // =================== أرشفة مستثمر ===================
    public function destroy(Investor $investor)
    {
        $investor->delete();
        $investor->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'deleted'
        ]);
        return redirect()->route('investors.index')->with('success','تم أرشفة المستثمر.');
    }

    // =================== استعادة مستثمر مؤرشف ===================
    public function restore($id)
    {
        $inv = Investor::withTrashed()->findOrFail($id);
        $inv->restore();
        $inv->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'restored'
        ]);
        return redirect()->back()->with('success','تم استعادة المستثمر.');
    }

    // =================== حذف دائم ===================
    public function forceDelete($id)
    {
        $inv = Investor::withTrashed()->findOrFail($id);
        foreach($inv->files as $f) Storage::disk('public')->delete($f->path);
        $inv->forceDelete();
        return redirect()->route('investors.index')->with('success','تم حذف المستثمر نهائيًا.');
    }

    // =================== ملاحظات المستثمر ===================
    public function storeNote(Request $r, Investor $investor)
    {
        $r->validate(['note'=>'required|string']);
        $note = $investor->notes()->create([
            'user_id' => auth()->id(),
            'note' => $r->note
        ]);
        $investor->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'note_added',
            'meta'=>['note_id'=>$note->id,'text'=>substr($r->note,0,200)]
        ]);
        return response()->json(['status'=>'success','note'=>$note->load('user')]);
    }

    public function deleteNote(Investor $investor, InvestorNote $note)
    {
        $note->delete();
        $investor->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'note_deleted',
            'meta'=>['note_id'=>$note->id]
        ]);
        return response()->json(['status'=>'success']);
    }

    // =================== رفع ملفات المستثمر ===================
    public function uploadFile(Request $r, Investor $investor)
    {
        $r->validate(['file'=>'required|file|max:51200']);
        $file = $r->file('file');
        $path = $file->store('investors/'.$investor->id,'public');
        $record = $investor->files()->create([
            'filename'=>$file->getClientOriginalName(),
            'path'=>$path,
            'mime'=>$file->getClientMimeType(),
            'size'=>$file->getSize(),
            'uploaded_by'=>auth()->id()
        ]);
        $investor->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'file_uploaded',
            'meta'=>['file_id'=>$record->id,'filename'=>$record->filename]
        ]);
        return response()->json(['status'=>'success','file'=>$record]);
    }

    public function deleteFile(Investor $investor, InvestorFile $file)
    {
        Storage::disk('public')->delete($file->path);
        $file->delete();
        $investor->activities()->create([
            'user_id'=>auth()->id(),
            'action'=>'file_deleted',
            'meta'=>['file_id'=>$file->id]
        ]);
        return response()->json(['status'=>'success']);
    }

    // =================== تصدير واستيراد ===================
    public function export($format='xlsx')
    {
        $fileName = 'investors_'.now()->format('Ymd_His').'.'.$format;
        return Excel::download(new InvestorsExport, $fileName);
    }

    public function import(Request $r)
    {
        $r->validate(['file'=>'required|file']);
        Excel::import(new InvestorsImport, $r->file('file'));
        return redirect()->back()->with('success','تم استيراد المستثمرين.');
    }
}
