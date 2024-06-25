<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'User registered successfully!');

            return response()->json([
                'status' => 200,
                'message' => 'User registered successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // if the form data is valid then attempt to login the user
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile.show');
            } else {
                return redirect()
                    ->route('account.login.index')
                    ->with('error', 'Invalid email or password!');
            }
        } else {
            return redirect()
                ->route('account.login.index')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        return view('front.account.profile');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:25',
            // check the email unique rule with the user id to ignore the current user email
            // if the email is not changed then it will ignore the current user email
            // otherwise, it will check the email unique rule with the other users
            'email' => 'required|email|unique:users,email,' . $id . ',id',
        ]);

        if ($validator->passes()) {
            // find the user by id
            $user = User::find($id);

            // update the user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;

            $user->save();

            session()->flash('success', 'User profile updated successfully!');

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

    public function updateProfilePicture(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        if ($validator->passes()) {
            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageFileName = $id . '-' . time() . '.' . $extension;
            $image->move(public_path('/profile_picture'), $imageFileName);

            $sourcePath = public_path('/profile_picture/' . $imageFileName);

            // create new image instance
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            // crop the best fitting 1:1 (200, 200) ratio and resize to 200, 200 pixel
            $image->cover(200, 200);
            $image->toPng()->save(public_path('/profile_picture/thumbnail/' . $imageFileName));

            // delete old image and thumbnail
            File::delete(public_path('/profile_picture/' . Auth::user()->image));
            File::delete(public_path('/profile_picture/thumbnail' . Auth::user()->image));

            User::where('id', $id)->update([
                'image' => $imageFileName,
            ]);

            session()->flash('success', 'Profile picture updated successfully!');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login.index');
    }

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view(
            'front.account.job.create',
            compact(
                'categories',
                'jobTypes'
            )
        );
    }

    public function saveJob(Request $request)
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
            $job = new Job();

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

            session()->flash('success', 'Job created successfully!');

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

    public function myJobs()
    {
        $jobs = Job::where('user_id', Auth::user()->id)->with(['jobType', 'applications'])->orderBy('created_at', 'DESC')->paginate(10);

        return view(
            'front.account.job.my-jobs',
            compact('jobs')
        );
    }

    public function editJob(Request $request, $id)
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id,
        ])->first();

        if ($job == NULL) {
            abort(404);
        }

        return view(
            'front.account.job.edit',
            compact(
                'job',
                'jobTypes',
                'categories',
            )
        );
    }

    public function updateJob(Request $request, $id)
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

    public function deleteJob(Request $request)
    {
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->id,
        ])->first();

        if ($job == NULL) {
            $message = 'Either job was deleted or you are not authorized to delete this job!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        Job::where('id', $request->id)->delete();

        $message = 'Job deleted successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function removeJob(Request $request)
    {
        $jobApplication = JobApplication::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($jobApplication == NULL) {
            $message = 'Either job application was removed or you are not authorized to remove this job!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        JobApplication::where('id', $request->id)->delete();

        $message = 'Job application removed successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function removeSavedJob(Request $request)
    {
        $savedJob = SavedJob::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($savedJob == NULL) {
            $message = 'Either job application was removed or you are not authorized to remove this job!';

            session()->flash('error', $message);

            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        SavedJob::where('id', $request->id)->delete();

        $message = 'Saved job removed successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function myJobApplications()
    {
        $jobApplications = JobApplication::where(
            'user_id',
            Auth::user()->id
        )
            ->with(
                [
                    'job',
                    'job.jobType',
                    'job.jobCategory',
                    'job.applications',
                ]
            )
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.my-job-applications', compact('jobApplications'));
    }

    public function savedJobs()
    {
        $savedJobs = SavedJob::where(
            ['user_id' => Auth::user()->id]
        )->with(
            [
                'job',
                'job.jobType',
                'job.jobCategory',
            ]
        )
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.saved-jobs', compact('savedJobs'));
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'old_password' => ['Old password does not match!'],
                ],
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        $message = 'Password updated successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
