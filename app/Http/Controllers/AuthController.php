<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login.index');
    }

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
            $user->password = bcrypt($request->password);
            $user->save();

            $message = 'User registered successfully!';
            // session()->flash('success', $message);

            // redirect to verification page with flash message
            return redirect()
                ->route('account.verification', $user->id)
                ->with('success', $message);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $userCredential = $request->only('email', 'password');
        $userData = User::where('email', $request->email)->first();

        // redirect to verification page if the user is not verified
        if ($userData && $userData->is_verified == 0) {
            $this->sendOtp($userData);

            return redirect()
                ->route('account.verification', $userData->id)
                ->with('error', 'Please verify your email address!');
        } else if ($validator->passes()) {
            // if the form data is valid then attempt to login the user
            if (Auth::attempt($userCredential)) {
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
        $user->password = bcrypt($request->new_password);
        $user->save();

        $message = 'Password updated successfully!';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function forgotPassword()
    {
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('account.forgot.password')
                ->withInput($request->only('email'))
                ->withErrors($validator);
        }

        $generatedPasswordResetToken = Str::random(50);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $generatedPasswordResetToken,
            'created_at' => now(),
        ]);

        $user = User::where('email', $request->email)->first();
        $actionUrl = env('APP_URL') . '/account/reset-password/' . $generatedPasswordResetToken;

        $mailData = [
            'token' => $generatedPasswordResetToken,
            'user' => $user,
            'actionUrl' => $actionUrl,
        ];

        Mail::to($request->email)->send(new PasswordResetEmail($mailData));

        return redirect()
            ->route('account.forgot.password')
            ->with('success', 'Password reset link has been sent to your email.');
    }

    public function resetPassword($tokenString)
    {
        $token = DB::table('password_reset_tokens')->where('token', $tokenString)->first();

        if ($token == NULL) {
            return redirect()
                ->route('account.forgot.password')
                ->with('error', 'Invalid password reset token!');
        }

        return view('front.account.reset-password', compact('tokenString'));
    }

    public function processResetPassword(Request $request)
    {
        $token = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if ($token == NULL) {
            return redirect()
                ->route('account.forgot.password')
                ->with('error', 'Invalid password reset token!');
        }

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('account.reset.password', $request->token)
                ->withErrors($validator);
        }

        User::where('email', $token->email)
            ->update(['password' => bcrypt($request->new_password)]);

        return redirect()
            ->route('account.login.index')
            ->with('success', 'Password changed successfully.');
    }

    public function verification($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user || $user->is_verified == 1) {
            return redirect('/');
        }

        $email = $user->email;

        $this->sendOtp($user);

        return view('front.account.otp-verification', compact('email'));
    }
