@include('front.include.header')
<style>
    label#email-error {
        width: 100%;
    }

</style>


<section class="contact mb-5">
    <div class="container login-main">
        <div class="row">
            <h1 class="title text-center">Login</h1>
            <div class="wrapper">
			   <ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
					  <a class="nav-link active" data-toggle="tab" href="#otp">Login with OTP</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" data-toggle="tab" href="#pass">Login with password</a>
					</li>
				  </ul>
			<div class="tab-content">
			  <div id="otp" class="container tab-pane active">
			   <form id="user_login_otp" method="POST" action="">
                    <div class="step1-1">
			             <p class="mandatory">(<em>*</em>) mandatory fields</p>
                         <label class="label"><span>Phone Number</span><span class="requard">*</span></label>
                         <input type="text" id="phone" class="input-text @error('phone') is-invalid @enderror" name="phone" placeholder="" maxlength="10" minlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" pattern="^\d{10}$"  value="{{ old('phone') }}">
                         <span id="phoneError-1" class="error d-none">Please Enter Your Phone Number !!</span><br>
                         <span id="phoneMessage-1" class="error d-none">Phone Number Does not exist!</span><br>
                        <div id="recaptcha-container-1"></div>
                        <div class="actions">
                            <button type="button" onClick="sendOtpMobileNumber(1)" class="btn login-btn btn-primary">Send OTP</button>
                        </div>
                    </div>
                    <div class="step2-1" id="verifyOTP" style="display:none;">
                        <div class="alert alert-success d-none" id="sentSuccessOTP-1"></div>
                        <div class="alert alert-danger d-none" id="errorOTP-1"></div>
                        <label for="">Enter OTP</label>
                        <input placeholder="Enter Your OTP" type="text" class="form-control" id="OTP-1"  onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                        <span id="otpError-1" class="error d-none">Please Enter OTP !!</span><br>
                        <span id="otpMessage-1" class="text-danger "></span><br>
                        <div class="actions">
                        <button name="send" type="button" onclick="verifyOTP('1')" class="btn login-btn btn-primary" >Verify OTP</button>
                        </div>
                    </div>
				</form>
				</div>
					
			 <div id="pass" class="container tab-pane fade">
                <div id="formContent">
                    <!-- Login Form -->
                    <form id="user_login" method="POST" action="{{ route('login') }}">
                        @csrf
                        @if ($message = Session::get('login-random'))
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endif
                        @if (session()->has('session_message'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session()->get('session_message') }}
                        </div>
                        @endif
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>
                        <label class="label"><span>Phone Number</span><span
                                class="requard">*</span></label>
                        <input type="text" id="email" class="input-text @error('email') is-invalid @enderror"
                            name="email" placeholder="" value="{{ old('email') }}">
                        <label style="white-space: pre-wrap;" class="label"><span>Password</span><span
                                class="requard">*</span></label>
                        <input type="password" id="password" class="input-text @error('password') is-invalid @enderror"
                            name="password" placeholder="">
                        <div class="actions">
                            <button type="submit" class="btn login-btn btn-primary">{{ __('Login') }}</button>
                            <a class="remind" href="{{ url('forgot-password') }}">Forgot Password?</a>
                        </div>
                    </form>
                </div>
			  </div>
			  </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>

  var firebaseConfig = {
  apiKey: "AIzaSyDSn9pjng5Zb7ihIQNyh86l0p7ewbQJvdM",
  authDomain: "liftdedoo-692e1.firebaseapp.com",
  projectId: "liftdedoo-692e1",
  storageBucket: "liftdedoo-692e1.appspot.com",
  messagingSenderId: "621188197237",
  appId: "1:621188197237:web:4a8195a1fc47c714fbc13c",
  measurementId: "G-TF5X1WLYM0"
};

firebase.initializeApp(firebaseConfig);
captcha(1);
function captcha(id)
    {
        render(id);
    }

    function render(id) {
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container-'+id);
        recaptchaVerifier.render();
    }
 function sendOtpMobileNumber(bookingId) {
        var mobileNumber = $("#phone").val();
        var number = "+91"+$("#phone").val();
        if(mobileNumber == ""){
            $("#phoneError-"+bookingId).removeClass("d-none");
            return false;
        }else{
            $("#phoneError-"+bookingId).addClass("d-none");
             $.ajax({
                url : "{{route('MobileNoValidate')}}",
                data : {
                    mobile_no : mobileNumber,
                    _token: '{{ csrf_token() }}',
                },
                type : "POST",
                success: function(data) {
                    if(data.user_exist=='0'){
                        $("#phoneMessage-"+bookingId).removeClass("d-none");
                        return false;
                    }else{
                        $("#phoneMessage-"+bookingId).addClass("d-none");
                        firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {


                            window.confirmationResult=confirmationResult;
                            coderesult=confirmationResult;
                            console.log(coderesult);

                            $("#sentSuccess-"+bookingId).text("Message Sent Successfully.");
                            $("#sentSuccess"+bookingId).removeClass("d-none");
                            $.ajax({
                                url : "{{route('checkUserMobile')}}",
                                data : {
                                    mobile_no : mobileNumber,
                                    _token: '{{ csrf_token() }}',
                                },
                                type : "POST",
                                success: function(data) {
                                    console.log(data);
                                    $(".step2-"+bookingId).show();
                                    $(".step1-"+bookingId).hide();
                                    $("#sentSuccessOTP-"+bookingId).html("OTP sent successfully. Please verify your mobile number");
                                    $("#sentSuccessOTP-"+bookingId).removeClass("d-none");
                                }
                            })
                        }).catch(function (error) {
                            console.log(error);
                            $("#error-"+bookingId).text(error.message);
                            $("#error-"+bookingId).removeClass("d-none");
                        });
                    }
                }
            });
        }

    }
    
    function verifyOTP(bookingId) {
        var otpNumber = $("#OTP-"+bookingId).val();
        var mobileNumber = $("#phone").val();
        if(otpNumber == ""){
            $("#otpError-"+bookingId).removeClass("d-none");
            return false;
        }else{
            $("#otpError-"+bookingId).addClass("d-none");
        var code = $("#OTP-"+bookingId).val();
        coderesult.confirm(code).then(function (result) {
                var user=result.user;
                $.ajax({
                    url : "{{route('mobile-login-otp')}}",
                    data : {
                        otp_no : otpNumber,
                        mobile_no: mobileNumber,
                        _token: '{{ csrf_token() }}',
                    },
                    type : "POST",
                    success: function(data) {
                        if(data.status == "success") {
                            $("#errorOTP-"+bookingId).addClass("d-none");
                            $("#sentSuccessOTP-"+bookingId).html("Congratulation! sucessfully you have verified your mobile number.");
                            $("#sentSuccessOTP-"+bookingId).removeClass("d-none");
                            location.href='my-account';
                            // window.setTimeout(
                            // function(){
                            //     window.document.location.reload(true);
                            // },3000);
                        }else{
                            $('#otpMessage-'+bookingId).html(data);
                        }
                    }
                })
            }).catch(function (error) {
                $("#errorOTP-"+bookingId).text(error.message);
                $("#sentSuccessOTP-"+bookingId).addClass("d-none");
                $("#errorOTP-"+bookingId).removeClass('d-none');
            });
        }
    }   
    $(".alert.message").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
<script>
    jQuery('#user_login').validate({
        rules: {
            email: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
            },

        },
        messages: {
            email: {
                required: "Please enter your mobile number",
                number: "Please enter only number",
                minlength: "Mobile number must be 10 digits",
                maxlength: "Mobile number must be 10 digits"
            },
            password: {
                required: "Please enter your password",
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
     jQuery('#user_login_otp').validate({
        rules: {
            email: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
            },

        },
        messages: {
            email: {
                required: "Please enter your mobile number",
                number: "Please enter only number",
                minlength: "Mobile number must be 10 digits",
                maxlength: "Mobile number must be 10 digits"
            },
            password: {
                required: "Please enter your password",
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@include('front.include.footer')
