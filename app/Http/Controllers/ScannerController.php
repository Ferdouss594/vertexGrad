<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ScannerController extends Controller
{
    public function startUpload(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $plainToken = Str::random(64);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'status' => 'Pending',
            'upload_token' => hash('sha256', $plainToken),
            'scanner_status' => 'session_creating',
            'student_id' => $user->id,
            'priority' => 'Medium',
            'progress' => 0,
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Platform-Token' => config('services.scanner.token'),
        ])->post(
            rtrim(config('services.scanner.base_url'), '/') . '/api/platform/upload-session',
            [
                'project_id' => $project->project_id,
                'project_name' => $project->name,
                'student_id' => $user->id,
                'student_name' => $user->name ?? 'Student',
                'token' => $plainToken,
            ]
        );

        if (! $response->successful()) {
            $project->update([
                'scanner_status' => 'session_failed',
            ]);

            return back()->withErrors([
                'scanner' => 'فشل الاتصال بنظام الفحص.',
            ])->withInput();
        }

        $data = $response->json();

        if (! isset($data['upload_url'])) {
            $project->update([
                'scanner_status' => 'session_failed',
            ]);

            return back()->withErrors([
                'scanner' => 'لم يتم استلام رابط الرفع من نظام الفحص.',
            ])->withInput();
        }

        $project->update([
            'scanner_status' => 'session_created',
        ]);

        return redirect()->away($data['upload_url']);
    }
}