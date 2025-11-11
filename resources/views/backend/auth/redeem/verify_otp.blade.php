<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #cbcccfff 0%, #d0d3daff 100%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-main-body {
        background: #fff;
        border-radius: 16px;
        padding: 40px 35px;
        width: 400px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .panel-heading {
        text-align: center;
        margin-bottom: 25px;
    }

    .panel-heading h3 {
        font-weight: 700;
        color: #1e3a8a;
        font-size: 24px;
        text-transform: uppercase;
    }

    .form-horizontal {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-horizontal label {
        font-weight: 500;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }

    .form-horizontal input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .form-horizontal input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .btn-primary {
        color: #fff;
        background-color: #2563eb;
        padding: 12px 20px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #1e40af;
        transform: translateY(-2px);
    }

    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-top: 15px;
        text-align: center;
        font-size: 14px;
        animation: fadeIn 0.4s ease;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #22c55e;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .alert-info {
        background-color: #e0f2fe;
        color: #075985;
        border: 1px solid #38bdf8;
    }

    span.validation-error {
        color: #dc2626;
        font-size: 13px;
        display: none;
    }
</style>

<div class="auth-main-body">
    <div class="panel-heading">
        <h3>Two-Factor Authentication</h3>
        <p style="font-size: 14px; color: #555;">We’ve sent a verification code to your email.</p>
    </div>

    <div id="message-box"></div>

    <form id="otpForm" class="form-horizontal" method="POST" novalidate>
        @csrf
        <div class="form-group">
            <div>
                <label for="one_time_password">Enter OTP</label>
                <input id="one_time_password" type="text" name="one_time_password" placeholder="6-digit code" required maxlength="6" pattern="[0-9]*">
                <input type="hidden" id="user_email" name="email" value="{{$email}}" required>
            </div>
            <span class="validation-error" id="otp-error">OTP is required and must be 6 digits.</span>
        </div>

        <div class="btn-group">
            <button type="button" id="sendOtpBtn" class="btn btn-primary">Send OTP</button>
            <button type="button" id="verifyOtpBtn" class="btn btn-primary">Verify OTP</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Clear message
        function showMessage(type, text) {
            let alertClass =
                type === "success" ?
                "alert-success" :
                type === "error" ?
                "alert-error" :
                "alert-info";
            $("#message-box").html('<div class="alert ' + alertClass + '">' + text + "</div>");
        }

        // Validate OTP field
        function validateOtp() {
            let otp = $("#one_time_password").val().trim();
            if (otp === "" || otp.length !== 6 || isNaN(otp)) {
                $("#otp-error").show();
                return false;
            } else {
                $("#otp-error").hide();
                return true;
            }
        }

        // Send OTP
        $("#sendOtpBtn").on("click", function(e) {
            e.preventDefault();
            showMessage("info", "Sending OTP...");
            let email = $("#user_email").val();

            $.ajax({
                method: "POST",
                url: "{{route('redeem_sendotp')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email,

                },
                success: function(response) {
                    showMessage("success", response.message || "OTP sent successfully!");
                },
                error: function() {
                    showMessage("error", "Failed to send OTP. Please try again.");
                },
            });
        });

        // Verify OTP
        $("#verifyOtpBtn").on("click", function(e) {
            e.preventDefault();
            if (!validateOtp()) return;

            let otp = $("#one_time_password").val();
            let email = $("#user_email").val();
            showMessage("info", "Verifying OTP...");

            $.ajax({
                method: "POST",
                url: "{{route('verify_otp')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    one_time_password: otp,
                    email: email,
                },
                success: function(response) {
                    if (response.success) {
                        showMessage("success", response.message);
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    } else {
                        showMessage("error", response.message);
                    }
                },
                error: function() {
                    showMessage("error", "Verification failed. Try again.");
                },
            });
        });
    });
</script>