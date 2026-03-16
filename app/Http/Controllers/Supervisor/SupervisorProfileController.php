<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorProfileController extends Controller
{
    protected function currentSupervisor()
    {
        $user = auth('admin')->user();
        abort_unless($user && $user->role === 'Supervisor', 403);

        return $user;
    }

    public function index()
    {
        $user = $this->currentSupervisor();

        return view('supervisor.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $this->currentSupervisor();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('supervisor.profile.index')
            ->with('success', 'Profile updated successfully.');
    }
}