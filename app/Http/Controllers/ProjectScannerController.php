<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProjectScannerController extends Controller
{
    // عرض نتائج الفحص لمشروع محدد
    public function show($projectId)
    {
        $user = auth()->user();

        // 1️⃣ التحقق من صلاحية الوصول
        if (!$user->can_access_scanner) {
            abort(403, "ليس لديك صلاحية الوصول إلى منصة الفحص");
        }

        // 2️⃣ جلب بيانات المشروع من المنصة الثانية
        $project = DB::table('projects')->where('id', $projectId)->first();
        if (!$project) {
            abort(404, "المشروع غير موجود");
        }

        // 3️⃣ استدعاء API من المنصة الأولى
        $apiToken = $user->scanner_api_token; // تخزين الـ Token في عمود user
        $scannerUrl = "http://scanner-platform.local/api/project/{$projectId}/results";

        $response = Http::withToken($apiToken)->get($scannerUrl);

        if (!$response->ok()) {
            abort($response->status(), "حدث خطأ عند جلب نتائج الفحص من المنصة الأولى");
        }

        $results = $response->json();

        // 4️⃣ تحديث جدول المشاريع في المنصة الثانية
        DB::table('projects')->where('id', $projectId)->update([
            'scanner_total_issues' => $results['total_issues'],
            'scanner_status' => 'processed'
        ]);

        // 5️⃣ تحديث الملفات في جدول project_files
        foreach ($results['files'] as $file) {
            DB::table('project_files')->updateOrInsert(
                ['project_id' => $results['project_id'], 'file_name' => $file['file_name']],
                ['issues_count' => $file['issues_count']]
            );
        }

        // 6️⃣ عرض النتائج للمستخدم
        return view('projects.scanner_results', [
            'project' => $project,
            'results' => $results
        ]);
    }
}