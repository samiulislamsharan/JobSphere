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

    public function edit()
    {
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