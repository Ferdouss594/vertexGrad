<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use App\Http\Requests\Frontend\SubmitProjectStep1Request;
use App\Http\Requests\Frontend\SubmitProjectFinalRequest;
use App\Notifications\ProjectSubmittedNotification;
use Illuminate\Support\Facades\Notification;



class ProjectSubmissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1
    |--------------------------------------------------------------------------
    */

    public function step1()
    {
        return view('frontend.submissions.step1');
    }


public function postStep1(SubmitProjectStep1Request $request)
{
    $data = $request->validated();

    $temp = [
        'temp_photos' => [],
    ];

    // store images (multiple)
    if ($request->hasFile('project_photos')) {
        foreach ($request->file('project_photos') as $img) {
            $temp['temp_photos'][] = $img->store('tmp', 'public');
        }
    }

    // store video (single)
    if ($request->hasFile('project_video')) {
        $temp['temp_video'] = $request->file('project_video')->store('tmp', 'public');
    }

    // Remove file keys from session payload
    unset($data['project_photos'], $data['project_video']);

    // Merge into session
    session()->put('project_data', array_merge($data, $temp));

    return redirect()->route('project.submit.step2');
}

    /*
    |--------------------------------------------------------------------------
    | STEP 2
    |--------------------------------------------------------------------------
    */

    public function step2()
    {
        return view('frontend.submissions.step2');
    }

    public function postStep2(Request $request)
    {
        $step2 = $request->validate([
            'lead_name'        => 'required',
            'institution_name' => 'required'
        ]);

        $data = session()->get('project_data', []);
        session()->put('project_data', array_merge($data, $step2));

        return redirect()->route('project.submit.step3');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3
    |--------------------------------------------------------------------------
    */

    public function step3()
    {
        return view('frontend.submissions.step3');
    }

    public function postStep3(Request $request)
    {
        $step3 = $request->validate([
            'requested_amount' => 'required|numeric',
            'duration_months'  => 'required'
        ]);

        $data = session()->get('project_data', []);
        session()->put('project_data', array_merge($data, $step3));

        return redirect()->route('project.submit.step4');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 (Account Setup)
    |--------------------------------------------------------------------------
    */

    public function step4()
    {
        if (Auth::check()) {
            return redirect()->route('project.submit.confirm');
        }

        return view('frontend.submissions.step4');
    }

    public function postStep4(Request $request)
    {
        $userData = $request->validate([
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|confirmed|min:8',
            'terms_agreement' => 'accepted',
        ]);

        session()->put('user_data', [
            'email'    => $userData['email'],
            'password' => $userData['password'],
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
    | FINAL SUBMISSION
    |--------------------------------------------------------------------------
    */

    public function submitFinal(SubmitProjectFinalRequest $request)
    {
        \Log::info('submitFinal hit', [
            'has_project_data' => session()->has('project_data'),
            'has_user_data'    => session()->has('user_data'),
            'web_auth'         => auth('web')->check(),
            'user_id'          => auth('web')->id(),
        ]);

        $projectData = session()->get('project_data');

        if (!$projectData) {
            return redirect()
                ->route('project.submit.step1')
                ->with('error', 'Session expired.');
        }

        // ✅ Only pull/require user_data if guest
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

            // ✅ Create User (ONLY if not logged in on web guard)
            if (!auth('web')->check()) {

                $username = strstr($userData['email'], '@', true);

                if (User::where('username', $username)->exists()) {
                    $username .= rand(10, 99);
                }

                $user = User::create([
                    'name'     => $projectData['lead_name'],
                    'username' => $username,
                    'email'    => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role'     => 'Student',
                    'status'   => 'Active'
                ]);

                auth('web')->login($user);
            }

            // ✅ Create Project (use web user id)
            $project = Project::create([
                'name'        => $projectData['project_title'],
                'description' => $projectData['abstract'],
                'category'    => $projectData['discipline'],
                'budget'      => $projectData['requested_amount'] ?? null,
                'student_id'  => auth('web')->id(),
                'status'      => 'Pending',
            ]);

            // Move Media From Temp to Media Library
            if (!empty($projectData['temp_photos']) && is_array($projectData['temp_photos'])) {
                foreach ($projectData['temp_photos'] as $path) {
                    if (!$path) continue;

                    $full = storage_path('app/public/' . $path);

                    if (file_exists($full)) {
                        $project->addMedia($full)->toMediaCollection('images');
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            if (!empty($projectData['temp_video'])) {
                $videoFull = storage_path('app/public/' . $projectData['temp_video']);

                if (file_exists($videoFull)) {
                    $project->addMedia($videoFull)->toMediaCollection('videos');
                    Storage::disk('public')->delete($projectData['temp_video']);
                }
            }

            // ✅ Notify Managers
            $managers = User::where('role', 'Manager')->get();
            Notification::send($managers, new ProjectSubmittedNotification($project));

            DB::commit();

            session()->forget(['project_data', 'user_data']);

            return redirect()
                ->route('dashboard.academic')
                ->with('success', 'Project submitted successfully!');

        } catch (FileIsTooBig $e) {
            DB::rollBack();

            return redirect()
                ->route('project.submit.confirm')
                ->with('error', 'Uploaded file exceeds allowed size.');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('submitFinal failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->route('project.submit.confirm')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESUME
    |--------------------------------------------------------------------------
    */

    public function resume()
    {
        if (session()->has('user_data')) {
            return redirect()->route('project.submit.confirm');
        }

        if (session()->has('project_data')) {
            return redirect()->route('project.submit.step4');
        }

        return redirect()->route('project.submit.step1');
    }
}