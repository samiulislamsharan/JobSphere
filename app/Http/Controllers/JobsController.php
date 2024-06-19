<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $jobTypes = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        $jobs = Job::where('status', 1);

        // keyword filter
        if (!empty($request->keywords)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'LIKE', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'LIKE', '%' . $request->keywords . '%');
            });
        }

        // location filter
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // category filter
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // job type filter
        $jobTypeArray = [];

        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // experience filter
        if (!empty($request->experience)) {

            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with('jobType');

        if (!empty($request->sort) && $request->sort == 1) {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs = $jobs->paginate(9);

        return view(
            'front.jobs',
            compact(
                'jobs',
                'jobTypes',
                'categories',
                'jobTypeArray',
            )
        );
    }

    public function detail($id)
    {
        $job = Job::where(
            [
                'id' => $id,
                'status' => 1
            ]
        )->with(
            [
                'jobType', 'jobCategory'
            ]
        )->first();

        if (!$job) {
            return redirect()->route('jobs');
        }

        return view('front.job-detail', compact('job'));
    }
}