<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/b9b86b707b.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>{{ $mailData['title'] }}</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header h2">JobSphere</div>
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
                    <button class="btn btn-primary" type="button" id="otp-copy">
                        <i class="fa-regular fa-copy"></i> Copy
                    </button>
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
            {{-- <div class="card-footer text-muted">
                <p class="card-text">If you're having trouble with the button above, copy and paste the URL below
                    into your web browser.</p>
                <p class="card-text"><a href="javascript:void(0);" class="link-offset-3">{{ $mailData['actionUrl'] }}</a></p>
            </div> --}}
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#otp-copy').click(function() {
                var copyText = document.getElementById("otp");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");

                $('#otp-copy').html('<i class="fa-solid fa-check"></i></i> Copied');
            });
        });
    </script>
</body>

</html>
