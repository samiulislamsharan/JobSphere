<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function applyJob(Request $request)
    {
        $id = $request->id;
        $job = Job::where('id', $id)->first();

        if ($job == NULL) {
            $message = 'Job does not exist';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // prevent user from applying on their own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You cannot apply on your own job.';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // prevent user from applying twice on a same job
        $jobApplicationCount = JobApplication::where(
            [
                'user_id' => Auth::user()->id,
                'job_id' => $id,
            ]
        )->count();

        if ($jobApplicationCount > 0) {
            $message = 'You cannot apply on a same job twice';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $application = new JobApplication();

        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();

        $application->save();

        // send email to employer
        $employer = User::where('id', $employer_id)->first();

        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job
        ];

        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message = 'Successfully applied to the job!';

        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function saveJob(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);

        if ($job == NULL) {
            $message = 'Job does not exist';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $savedJobCount = SavedJob::where(
            [
                'user_id' => Auth::user()->id,
                'job_id' => $id,
            ]
        )->count();

        if ($savedJobCount > 0) {
            $message = 'You have already saved this job';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $savedJob = new SavedJob();
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        $message = 'Job saved successfully';

        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
