<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $jobsCount = Job::where('status', 1)->count();
        $applicantCount = JobApplication::count();
        $categoryCount = Category::count();
        $jobTypeCount = JobType::count();

        return view(
            'admin.dashboard',
            compact(
                'usersCount',
                'jobsCount',
                'applicantCount',
                'categoryCount',
                'jobTypeCount',
            )
        );
    }
}
