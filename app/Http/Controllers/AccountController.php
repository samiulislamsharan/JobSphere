<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobType;
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
        $id = Auth::user()->id;

        $user = User::find($id);

        return view(
            'front.account.profile',
            compact('user')
        );
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
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
}
