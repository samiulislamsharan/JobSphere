<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // show the registration form
    public function registration()
    {
        return view('front.account.registration');
    }

    // register the user
    public function registerUser(Request $request)
    {
        // validate the form data
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

    // show the login form
    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        // validate the form data
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

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login.index');
    }
}
