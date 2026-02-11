<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Make sure this is here!
use Illuminate\Support\Facades\Hash;

class ProjectSubmissionController extends Controller
{
    // Step 1: Overview
public function step1() { return view('frontend.submissions.step1'); }

public function postStep1(Request $request) {
    $data = $request->validate([
        'project_title' => 'required|max:100',
        'abstract' => 'required|max:1000',
        'discipline' => 'required'
    ]);

    session()->put('project_data', $data);

    // Logic for the "Save Draft" button
    if ($request->action === 'draft') {
        if (auth()->check()) {
            // Save to database as 'Draft' status
            Project::updateOrCreate(
                ['name' => $data['project_title'], 'student_id' => auth()->id()],
                ['description' => $data['abstract'], 'category' => $data['discipline'], 'status' => 'Draft']
            );
            return back()->with('success', 'Draft saved to your dashboard!');
        } else {
            return back()->with('error', 'Please create an account or login to save drafts.');
        }
    }

    return redirect()->route('project.submit.step2');
}

    // Step 2: Team (Principal Investigator)
    public function step2() { return view('frontend.submissions.step2'); }
    public function postStep2(Request $request) {
        $step2 = $request->validate(['lead_name' => 'required', 'institution_name' => 'required']);
        $data = session()->get('project_data');
        session()->put('project_data', array_merge($data, $step2));
        return redirect()->route('project.submit.step3');
    }

    // Step 3: Budget
    public function step3() { return view('frontend.submissions.step3'); }
    public function postStep3(Request $request) {
        $step3 = $request->validate(['requested_amount' => 'required|numeric', 'duration_months' => 'required']);
        $data = session()->get('project_data');
        session()->put('project_data', array_merge($data, $step3));
        return redirect()->route('project.submit.step4');
    }

    // Step 4: Account (The Registration)
    public function step4() { 
        if(Auth::check()) return redirect()->route('project.submit.confirm');
        return view('frontend.submissions.step4'); 
    }

    public function postStep4(Request $request) {
        $userData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);
        session()->put('user_data', $userData);
        return redirect()->route('project.submit.confirm');
    }

    // FINAL SUBMISSION
    public function confirm() {
        $projectData = session()->get('project_data');
        $userData = session()->get('user_data');

        // If session is empty, redirect back to step 1
        if (!$projectData) {
            return redirect()->route('project.submit.step1')->with('error', 'Session expired. Please start again.');
        }

        return view('frontend.submissions.confirm', compact('projectData', 'userData'));
    }

    public function resume() {
    if (session()->has('user_data')) {
        return redirect()->route('project.submit.confirm');
    }
    if (session()->has('project_data')) {
        return redirect()->route('project.submit.step4');
    }
    return redirect()->route('project.submit.step1');
}
public function submitFinal(Request $request) {
        $projectData = session()->get('project_data');
        $userData = session()->get('user_data');

        if (!$projectData) {
            return redirect()->route('project.submit.step1')->with('error', 'Session expired.');
        }

        // Use a Database Transaction for safety
        return \DB::transaction(function () use ($projectData, $userData) {
            
            // 1. Create User (if guest)
            if (!auth()->check()) {
                // Generate a unique username from email (e.g., "ali" from "ali@gmail.com")
                $username = strstr($userData['email'], '@', true);
                
                // Check if username exists, if so, add a random number
                if (User::where('username', $username)->exists()) {
                    $username = $username . rand(10, 99);
                }

                $user = User::create([
                    'name'     => $projectData['lead_name'], 
                    'username' => $username, // FIX: Added the missing username
                    'email'    => $userData['email'],
                    'password' => $userData['password'], 
                    'role'     => 'Student',
                    'status'   => 'Active'
                ]);
                
                Auth::login($user);
            }

            // 2. Create the Project
            Project::create([
                'name'        => $projectData['project_title'],
                'description' => $projectData['abstract'],
                'category'    => $projectData['discipline'],
                'budget'      => $projectData['requested_amount'],
                'student_id'  => auth()->id(),
                'status'      => 'Pending',
            ]);

            // 3. Cleanup
            session()->forget(['project_data', 'user_data']);

            return redirect()->route('dashboard.academic')->with('success', 'Project submitted successfully!');
        });
    }
}
