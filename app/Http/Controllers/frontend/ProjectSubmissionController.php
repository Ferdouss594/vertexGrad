<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\SubmitProjectStep1Request;
use App\Http\Requests\Frontend\SubmitProjectFinalRequest;
use App\Notifications\ProjectSubmittedNotification;
use App\Notifications\ProjectPendingNotification;

class ProjectSubmissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1
    |--------------------------------------------------------------------------
    */

    public function step1()
    {
        $this->ensureGuestOrStudent();
        return view('frontend.submissions.step1');
    }

    public function postStep1(SubmitProjectStep1Request $request)
    {
        $this->ensureGuestOrStudent();

        $data = $request->validated();

        session()->put('project_data', array_merge(
            session()->get('project_data', []),
            [
                'project_title' => $data['project_title'],
                'abstract' => $data['abstract'],
                'discipline' => $data['discipline'],
                'project_type' => $data['project_type'],
                'problem_statement' => $data['problem_statement'],
                'target_beneficiaries' => $data['target_beneficiaries'],
                'project_nature' => $data['project_nature'],
            ]
        ));

        return redirect()->route('project.submit.step2');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2
    |--------------------------------------------------------------------------
    */

    public function step2()
    {
        $this->ensureGuestOrStudent();
        return view('frontend.submissions.step2');
    }

    public function postStep2(Request $request)
    {
        $this->ensureGuestOrStudent();

        $step2 = $request->validate([
            'student_name' => 'required|string|max:150',
            'academic_level' => 'required|string|max:100',
            'supervisor_name' => 'required|string|max:150',
            'supervisor_title' => 'required|string|max:150',
            'university_name' => 'required|string|max:150',
            'college_name' => 'required|string|max:150',
            'department' => 'required|string|max:150',
            'governorate' => 'required|string|max:100',
        ]);

        session()->put('project_data', array_merge(
            session()->get('project_data', []),
            $step2
        ));

        return redirect()->route('project.submit.step3');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3
    |--------------------------------------------------------------------------
    */

    public function step3()
    {
        $this->ensureGuestOrStudent();
        return view('frontend.submissions.step3');
    }

    public function postStep3(Request $request)
    {
        $this->ensureGuestOrStudent();

        $step3 = $request->validate([
            'is_feasible' => 'required|string|max:50',
            'local_implementation' => 'required|string|max:50',
            'expected_impact' => 'required|string',
            'community_benefit' => 'required|string',
            'needs_funding' => 'required|string|max:10',
            'requested_amount' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1|max:60',
            'support_type' => 'required|string|max:100',
            'budget_breakdown' => 'required|string',
            'milestone_1' => 'required|string|max:255',
            'milestone_1_month' => 'required|integer|min:1|max:60',
            'milestone_2' => 'required|string|max:255',
            'milestone_2_month' => 'required|integer|min:1|max:60',
            'milestone_3' => 'required|string|max:255',
            'milestone_3_month' => 'required|integer|min:1|max:60',
        ]);

        session()->put('project_data', array_merge(
            session()->get('project_data', []),
            $step3
        ));

        return redirect()->route('project.submit.step4');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4
    |--------------------------------------------------------------------------
    */

    public function step4()
    {
        $this->ensureGuestOrStudent();

        if (auth('web')->check()) {
            return redirect()->route('project.submit.confirm');
        }

        return view('frontend.submissions.step4');
    }

    public function postStep4(Request $request)
    {
        $this->ensureGuestOrStudent();

        if (auth('web')->check()) {
            session()->put('user_data', [
                'email' => auth('web')->user()->email,
                'data_confirmation' => $request->boolean('data_confirmation', true),
                'terms_agreement' => $request->boolean('terms_agreement', true),
            ]);

            return redirect()->route('project.submit.confirm');
        }

        $userData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'data_confirmation' => 'accepted',
            'terms_agreement' => 'accepted',
        ]);

        session()->put('user_data', [
            'email' => $userData['email'],
            'password' => $userData['password'],
            'data_confirmation' => true,
            'terms_agreement' => true,
        ]);

        return redirect()->route('project.submit.confirm');
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM
    |--------------------------------------------------------------------------
    */

    public function confirm()
    {
        $this->ensureGuestOrStudent();

        $projectData = session()->get('project_data');
        if (!$projectData) {
            return redirect()
                ->route('project.submit.step1')
                ->with('error', 'Session expired.');
        }

        $userData = session()->get('user_data');

        return view('frontend.submissions.confirm', compact('projectData', 'userData'));
    }

    /*
    |--------------------------------------------------------------------------
    | FINAL = START TECHNICAL SCAN
    |--------------------------------------------------------------------------
    */

    public function submitFinal(SubmitProjectFinalRequest $request)
    {
        $this->ensureGuestOrStudent();

        $projectData = session()->get('project_data');

        if (!$projectData) {
            return redirect()
                ->route('project.submit.step1')
                ->with('error', 'Session expired.');
        }

        $userData = null;

        if (!auth('web')->check()) {
            $userData = session()->get('user_data');

            if (!$userData) {
                return redirect()
                    ->route('project.submit.step4')
                    ->with('error', 'Account data missing.');
            }
        }

        try {
            DB::beginTransaction();

            // 1) Create user if guest
            if (!auth('web')->check()) {
                $username = strstr($userData['email'], '@', true);

                if (User::where('username', $username)->exists()) {
                    $username .= rand(10, 99);
                }

                $user = User::create([
                    'name' => $projectData['student_name'] ?? $projectData['project_title'],
                    'username' => $username,
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => 'Student',
                    'status' => 'active',
                ]);

                auth('web')->login($user);
            }

            $student = auth('web')->user();

            // 2) Create main platform project
            $project = Project::create([
                'name' => $projectData['project_title'],
                'description' => $projectData['abstract'],
                'category' => $projectData['discipline'],
                'budget' => $projectData['requested_amount'] ?? null,
                'student_id' => $student->id,
                'status' => 'scan_requested',
                'scanner_status' => 'pending',
                'scan_score' => null,
                'scan_report' => null,
                'scanned_at' => null,
            ]);

            // 3) Send to scanner platform
            $response = Http::withHeaders([
                'X-INTEGRATION-SECRET' => env('SCANNER_INTEGRATION_SECRET'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(env('SCANNER_INTEGRATION_URL'), [
                'name' => $project->name,
                'platform_project_id' => $project->project_id,
                'student_id' => $student->id,
                'student_name' => $projectData['student_name'] ?? $student->name,
                'student_email' => $student->email,
                'callback_url' => env('SCANNER_CALLBACK_URL'),
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to connect to scanner platform.');
            }

            $payload = $response->json();
            $scannerData = $payload['data'] ?? [];

            if (!($payload['success'] ?? false)) {
                throw new \Exception($payload['message'] ?? 'Scanner integration failed.');
            }

            if (empty($scannerData['scanner_project_id']) || empty($scannerData['token'])) {
                throw new \Exception('Scanner response missing required data.');
            }

            // 4) Update project with scanner link
            $project->update([
                'scanner_project_id' => $scannerData['scanner_project_id'],
                'scanner_status' => 'pending',
            ]);

            // 5) Notify managers that project entered scan stage
            $managers = User::where('role', 'Manager')
                ->where('status', 'active')
                ->get();

            if ($managers->count()) {
                Notification::send($managers, new ProjectSubmittedNotification($project));
            }

            // 6) Notify student
            if ($student) {
                $student->notify(new ProjectPendingNotification($project));
            }

            DB::commit();

            session()->forget(['project_data', 'user_data']);

            $scanUrl = rtrim(env('SCANNER_PUBLIC_BASE_URL'), '/') . '/?project_token=' . urlencode($scannerData['token']);

            return redirect()->away($scanUrl);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('submitFinal / start scan failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('project.submit.confirm')
                ->with('error', 'DEBUG: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESUME
    |--------------------------------------------------------------------------
    */

    public function resume()
    {
        $this->ensureGuestOrStudent();

        if (session()->has('user_data')) {
            return redirect()->route('project.submit.confirm');
        }

        if (session()->has('project_data')) {
            return redirect()->route('project.submit.step4');
        }

        return redirect()->route('project.submit.step1');
    }

    private function ensureGuestOrStudent()
    {
        if (auth('web')->check() && auth('web')->user()->role !== 'Student') {
            abort(403, 'Only students can submit projects.');
        }
    }
   
}