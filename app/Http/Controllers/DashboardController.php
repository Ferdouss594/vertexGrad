<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class DashboardController extends Controller
{
    // صفحة Dashboard للمستخدمين العاديين
    public function dashboard()
    {
        // يمكنك تعديل البيانات حسب حاجتك
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsers = User::where('status', 'pending')->count();

        return view('manager.dashboard', compact('totalUsers', 'activeUsers', 'pendingUsers'));
    }
     public function index()
    {
        return view('manager.dashboard'); // اسم الفيو اللي تبغاه
    }
}


