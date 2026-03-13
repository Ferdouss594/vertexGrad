<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::with(['media', 'student'])
            ->whereIn('status', ['Active','Completed'])
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.pages.home', compact('featuredProjects'));
    }
}