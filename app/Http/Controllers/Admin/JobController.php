<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'DESC')
            ->with(
                [
                    'user',
                    'jobType',
                    'jobCategory',
                    'applications'
                ]
            )->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);

        if ($job == NULL) {
            $message = 'Job not found!';
            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $jobTypes = JobType::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();

        return view(
            'admin.jobs.edit',
            compact(
                'job',
                'jobTypes',
                'categories',
            )
        );
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        if ($job == NULL) {
            $message = 'Job not found!';
            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $job->delete();

        $message = 'Job deleted successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
