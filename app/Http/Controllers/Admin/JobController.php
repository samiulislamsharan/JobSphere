<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('status', 1)
            ->with(
                [
                    'user',
                    'jobType',
                    'jobCategory',
                    'applications'
                ]
            )->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }
    }
}