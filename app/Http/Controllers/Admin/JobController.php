<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'company_name' => 'required|min:5|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = Job::find($id);

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->job_type;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            $job->save();

            session()->flash('success', 'Job updated successfully!');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
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