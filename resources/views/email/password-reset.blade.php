<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Password Reset Request</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header h2">JobSphere</div>
            <div class="card-body">
                <h4 class="card-title">Hi {{ $mailData['user']->name }}</h4>
                <p class="card-text">
                    You recently requested to reset your password for your account. Use
                    the button below to reset it.
                </p>

                <div class="d-grid gap-2">
                    <a href="{{ route('account.reset.password', $mailData['token']) }}" class="btn btn-primary my-4">
                        Reset Password
                    </a>
                </div>

                <p class="card-text">
                    For security, this request was received from a operating_system device using
                    browser_name .
                    If you did not request a password reset, please ignore this email or <a href="#">contact
                        support</a> if you have questions.
                </p>
                <p class="card-text">Thanks</p>
                <div class="card-text">The <span class="fw-bold">JobSphere</span> Team</div>
            </div>
            <div class="card-footer text-muted">
                <p class="card-text">If you're having trouble with the button above, copy and paste the URL below
                    into your web browser.</p>
                <p class="card-text"><a href="javascript:void(0);" class="link-offset-3">{{ $mailData['actionUrl'] }}</a></p>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
