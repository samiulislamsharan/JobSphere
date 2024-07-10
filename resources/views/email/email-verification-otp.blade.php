<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        a {
            color: #9c71e2;
        }
    </style>

    <title>{{ $mailData['title'] }}</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header h2 text-center">JobSphere Email Verification</div>
            <div class="card-body">
                <h4 class="card-title">Hi {{ $mailData['name'] }}</h4>
                <p class="card-text">
                    You recently requested to verify your {{ $mailData['email'] }} address for your account. Copy and
                    paste the code below
                    to verify your email address.
                </p>

                <div class="input-group mb-3">
                    <input value="{{ $mailData['otp'] }}" type="text" id="otp"
                        class="form-control text-center fs-1" placeholder="Email Verification OTP"
                        aria-label="Email Verification OTP" aria-describedby="otp-copy" readonly="true">
                </div>

                <p class="card-text">
                    For security, this request was received from a operating_system device using
                    browser_name .
                    If you did not request a password reset, please ignore this email or <a href="#"
                        class="link-offset-3">contact
                        support</a> if you have questions.
                </p>
                <p class="card-text">Thanks</p>
                <div class="card-text">The <span class="fw-bold">JobSphere</span> Team</div>
            </div>
            <div class="card-footer text-muted">
                <!-- copyright text -->
                <div class="text-center">Copyright &copy; 2024 <span class="fw-bold">JobSphere</span></div>
            </div>
        </div>
    </div>
</body>

</html>
