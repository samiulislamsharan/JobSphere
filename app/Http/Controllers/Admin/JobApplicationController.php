<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplication::orderBy('created_at', 'DESC')
            ->with(
                'job',
                'user',
                'employer',
            )->paginate(10);

        return view('admin.job-applications.index', compact('jobApplications'));
    }
}