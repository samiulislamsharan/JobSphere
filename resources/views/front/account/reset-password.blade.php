@extends('front.layouts.app')

@section('content')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            @include('front.account.shared.message')
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Reset your password</h1>
                        <form action="{{ route('account.process.reset.password') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $tokenString }}">
                            <div class="mb-3">
                                <label for="new_password" class="mb-2">New Password*</label>
                                <input type="password" value="" name="new_password" id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="Enter new password">

                                @error('new_password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirm_new_password" class="mb-2">Confirm new Password*</label>
                                <input type="password" value="" name="confirm_new_password" id="confirm_new_password"
                                    class="form-control @error('confirm_new_password') is-invalid @enderror"
                                    placeholder="Enter new password">

                                @error('confirm_new_password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="justify-content-between d-flex">
                                <button type="submit" class="btn btn-primary mt-2">Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>
                            Do not have an account?
                            <a href="{{ route('account.registration.index') }}">Register</a> Or
                            <a href="{{ route('account.login.index') }}">Login</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection
