<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project; // استيراد موديل المشروع

class PlatformLinkController extends Controller
{
    // صفحة ربط المشاريع
    public function showLinkPage()
    {
        // جلب مشاريع المنصة الرئيسية باستخدام الموديل
        $mainProjects = Project::all(); // هذا أفضل من DB::table
        
        // جلب المشاريع المرتبطة
        $linkedProjects = DB::table('project_scans')
            ->join('projects', 'project_scans.main_project_id', '=', 'projects.project_id')
            ->select('project_scans.*', 'projects.name as project_name')
            ->get();
        
        return view('admin.link-projects', [
            'mainProjects' => $mainProjects,
            'linkedProjects' => $linkedProjects
        ]);
    }
    
    // ربط المشاريع
    public function linkProjects(Request $request)
    {
        $request->validate([
            'main_project_id' => 'required',
            'scanner_project_id' => 'required'
        ]);
        
        // حفظ الربط
        DB::table('project_scans')->insert([
            'main_project_id' => $request->main_project_id,
            'scanner_project_id' => $request->scanner_project_id,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'تم ربط المشروع بنجاح');
    }
    
    // عرض نتائج الفحص لمشروع معين
    public function showScanResults($projectId)
    {
        // نجيب المشروع باستخدام الموديل
        $project = Project::find($projectId);
        
        if (!$project) {
            return redirect()->back()->with('error', 'المشروع غير موجود');
        }
        
        // نجيب رابط المشروع مع منصة الفحص
        $scanLink = DB::table('project_scans')
            ->where('main_project_id', $projectId)
            ->first();
        
        return view('projects.scan-results', [
            'project' => $project,
            'scanLink' => $scanLink
        ]);
    }
}