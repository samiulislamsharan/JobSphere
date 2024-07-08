@extends('front.layouts.app')

@section('content')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            @include('front.account.shared.message')
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <form method="POST" id="verificationForm">
                        @csrf
                        <section class="container-fluid bg-body-tertiary d-block">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
                                    <div class="card bg-white mb-5 mt-5 border-0 shadow">
                                        <div class="card-body p-5 text-center">
                                            <div class="h3">Verify</div>
                                            <p>Your code was sent to you via email</p>
                                            <input type="hidden" name="email" value="{{ $email }}">

                                            <div class="otp-field mb-4">
                                                <input type="number" />
                                                <input type="number" disabled />
                                                <input type="number" disabled />
                                                <input type="number" disabled />
                                                <input type="number" disabled />
                                                <input type="number" disabled />
                                            </div>

                                            <p id="message_error" class="text-danger"></p>
                                            <p id="message_success" class="text-success"></p>

                                            <p>Your OTP will expire in</p>
                                            <p class="time text-center fs-3"></p>

                                            <button type="submit" class="btn btn-primary mb-3">
                                                Verify
                                            </button>

                                            <p class="resend text-muted mb-0">
                                                Didn't receive code?
                                                <a id="resendOtpVerification" href="#">Request
                                                    again</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection

@section('customJS')
    <script type="text/javascript">
        const inputs = document.querySelectorAll(".otp-field > input");
        const button = document.querySelector(".btn");

        window.addEventListener("load", () => inputs[0].focus());
        button.setAttribute("disabled", "disabled");

        inputs[0].addEventListener("paste", function(event) {
            event.preventDefault();

            const pastedValue = (event.clipboardData || window.clipboardData).getData(
                "text"
            );
            const otpLength = inputs.length;

            for (let i = 0; i < otpLength; i++) {
                if (i < pastedValue.length) {
                    inputs[i].value = pastedValue[i];
                    inputs[i].removeAttribute("disabled");
                    inputs[i].focus;
                } else {
                    inputs[i].value = ""; // Clear any remaining inputs
                    inputs[i].focus;
                }
            }
        });

        inputs.forEach((input, index1) => {
            input.addEventListener("keyup", (e) => {
                const currentInput = input;
                const nextInput = input.nextElementSibling;
                const prevInput = input.previousElementSibling;

                if (currentInput.value.length > 1) {
                    currentInput.value = "";
                    return;
                }

                if (
                    nextInput &&
                    nextInput.hasAttribute("disabled") &&
                    currentInput.value !== ""
                ) {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                if (e.key === "Backspace") {
                    inputs.forEach((input, index2) => {
                        if (index1 <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }

                button.classList.remove("active");
                button.setAttribute("disabled", "disabled");

                const inputsNo = inputs.length;
                if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
                    button.classList.add("active");
                    button.removeAttribute("disabled");

                    return;
                }
            });
        });

        $(document).ready(function() {
            $('#verificationForm').submit(function(e) {
                e.preventDefault();

                // concat all input value in otp field and append it to form data
                var otp = '';
                $('.otp-field > input').each(function() {
                    otp += $(this).val();
                });

                $(this).append('<input type="hidden" name="otp" value="' + otp + '">');

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('account.otp.verified') }}",
                    data: formData,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            alert(res.msg);
                            window.open("/", "_self");
                        } else {
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });

            });

            $('#resendOtpVerification').click(function() {
                $(this).text('Wait...');
                var userMail = @json($email);

                $.ajax({
                    type: "GET",
                    url: "{{ route('account.otp.resend') }}",
                    data: {
                        email: userMail
                    },
                    success: function(res) {
                        $('#resendOtpVerification').text('Resend Verification OTP');
                        if (res.success) {
                            timer();
                            $('#message_success').text(res.msg);
                            setTimeout(() => {
                                $('#message_success').text('');
                            }, 3000);
                        } else {
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });

            });
        });

        function timer() {
            var seconds = 30;
            var minutes = 1;
            var timer = setInterval(() => {

                if (minutes < 0) {
                    $('.time').text('');
                    clearInterval(timer);
                } else {
                    let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                    let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                    $('.time').text(tempMinutes + ':' + tempSeconds);
                }

                if (seconds <= 0) {
                    minutes--;
                    seconds = 59;
                }
                seconds--;
            }, 1000);
        }

        timer();
    </script>
@endsection
