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
        $query = User::where('role', 'Investor');

        // البحث
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('username', 'like', "%{$s}%");
            });
        }

        // التصفية
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // الترتيب
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $investors = $query->orderBy($sortBy, $sortDir)
            ->paginate(15)
            ->withQueryString();

        // إحصائيات
        $stats = [
            'total'    => User::where('role', 'Investor')->count(),
            'active'   => User::where('role', 'Investor')->where('status', 'active')->count(),
            'inactive' => User::where('role', 'Investor')->where('status', 'inactive')->count(),
            'budget'   => Investor::sum('budget'),
            'archived' => 0,
        ];

        return view('investors.index', compact('investors', 'stats'));
    }

    // =================== صفحة الإضافة ===================
    public function create()
    {
        return view('investors.create');
    }

    // =================== حفظ مستثمر جديد ===================
    public function store(StoreInvestorRequest $request)
    {
        try {
            DB::transaction(function () use ($request, &$investor) {

                // ✅ إنشاء المستخدم
                $user = User::create([
                    'username' => $request->username,
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => $request->password, // يتم التشفير في Model
                    'role'     => 'Investor',
                    'status'   => $request->status ?? 'active',
                    'gender'   => $request->gender,
                    'city'     => $request->city,
                    'state'    => $request->state,
                ]);

                // ✅ إنشاء المستثمر
                $investor = Investor::create([
                    'user_id'         => $user->id,
                    'company'         => $request->company,
                    'position'        => $request->position,
                    'investment_type' => $request->investment_type,
                    'budget'          => $request->budget,
                    'source'          => $request->source,
                    'notes'           => $request->notes,
                ]);

                // ✅ تسجيل النشاط
                InvestorActivity::create([
                    'investor_id' => $investor->id,
                    'user_id'     => auth()->id(),
                    'action'      => 'created',
                    'meta'        => ['name' => $user->name],
                ]);
            });

            return redirect()
                ->route('investors.index')
                ->with('success', 'تم إنشاء المستثمر بنجاح');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // =================== عرض مستثمر ===================
    public function show(Investor $investor)
    {
        $investor->load(
            'user',
            'notes.user',
            'files.uploader',
            'activities.user'
        );

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
            'action'  => 'updated',
            'meta'    => ['updated_fields' => array_keys($request->validated())],
        ]);

        return redirect()
            ->route('investors.show', $investor)
            ->with('success', 'تم تحديث المستثمر');
    }

    // =================== حذف (أرشفة) ===================
    public function destroy(Investor $investor)
    {
        $investor->delete();

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'deleted',
        ]);

        return redirect()
            ->route('investors.index')
            ->with('success', 'تم أرشفة المستثمر');
    }

    // =================== استعادة ===================
    public function restore($id)
    {
        $investor = Investor::withTrashed()->findOrFail($id);
        $investor->restore();

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'restored',
        ]);

        return back()->with('success', 'تم استعادة المستثمر');
    }

    // =================== حذف نهائي ===================
    public function forceDelete($id)
    {
        $investor = Investor::withTrashed()->findOrFail($id);

        foreach ($investor->files as $file) {
            Storage::disk('public')->delete($file->path);
        }

        $investor->forceDelete();

        return redirect()
            ->route('investors.index')
            ->with('success', 'تم حذف المستثمر نهائيًا');
    }

    // =================== الملاحظات ===================
    public function storeNote(Request $request, Investor $investor)
    {
        $request->validate(['note' => 'required|string']);

        $note = $investor->notes()->create([
            'user_id' => auth()->id(),
            'note'    => $request->note,
        ]);

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'note_added',
            'meta'    => ['note_id' => $note->id],
        ]);

        return response()->json([
            'status' => 'success',
            'note'   => $note->load('user'),
        ]);
    }

    public function deleteNote(Investor $investor, InvestorNote $note)
    {
        $note->delete();

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'note_deleted',
        ]);

        return response()->json(['status' => 'success']);
    }

    // =================== الملفات ===================
    public function uploadFile(Request $request, Investor $investor)
    {
        $request->validate(['file' => 'required|file|max:51200']);

        $file = $request->file('file');
        $path = $file->store('investors/' . $investor->id, 'public');

        $record = $investor->files()->create([
            'filename'    => $file->getClientOriginalName(),
            'path'        => $path,
            'mime'        => $file->getClientMimeType(),
            'size'        => $file->getSize(),
            'uploaded_by'=> auth()->id(),
        ]);

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'file_uploaded',
            'meta'    => ['file_id' => $record->id],
        ]);

        return response()->json(['status' => 'success', 'file' => $record]);
    }

    public function deleteFile(Investor $investor, InvestorFile $file)
    {
        Storage::disk('public')->delete($file->path);
        $file->delete();

        $investor->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'file_deleted',
        ]);

        return response()->json(['status' => 'success']);
    }

    // =================== تصدير / استيراد ===================
    public function export($format = 'xlsx')
    {
        $fileName = 'investors_' . now()->format('Ymd_His') . '.' . $format;
        return Excel::download(new InvestorsExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file']);

        Excel::import(new InvestorsImport, $request->file('file'));

        return back()->with('success', 'تم استيراد المستثمرين');
    }
}
