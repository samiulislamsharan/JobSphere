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

    public function destroy(Request $request)
    {
        $id = $request->id;
        $jobApplication = JobApplication::find($id);

        if ($jobApplication == NULL) {
            $message = 'Either job application was deleted or you are not authorized to delete this job application!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $jobApplication->delete();

        $message = 'Job application deleted successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
