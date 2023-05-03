@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="contact mb-5">
    <div class="container driver-main">
        <div class="row">
            <h1 class="title text-center">Travel Agencies Registration</h1>
            <div class="wrapper">
                <div id="formContent">
                    <form id="travel_reg" method="POST" action="{{ route('driver.travel.reg') }}">
                        @csrf
                        @if (session()->has('email'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('email') }}
                            </div>
                        @endif
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>
                        <div class="field required">
                            <label class="label"><span>Travel Agencies Name</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="agency_name" class="input-text @error('name') is-invalid @enderror"
                                name="agency_name" placeholder="Enter Name" value="{{ old('agency_name') }}" autocomplete="name"
                                autofocus
                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                        </div>
                        <input type="hidden" name="role" value="2">
                        <div class="field required">
                            <label class="label"><span>Travel Agencies Trade License Number</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="registration_number"
                                class="input-text @error('registration_number') is-invalid @enderror"
                                name="registration_number" placeholder="Enter Licence Number"
                                onkeyup="this.value=this.value.replace(/[^0-9A-Za-z/\s-]/g, '')" value="{{ old('registration_number') }}">
                            <span id="unique-reg-error" style="display: none; color: red;">This Registration Number is
                                Already Exists</span>
                        </div>
                        <div class="field required">
                            <label class="label"><span>Number of vehicles</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="number_of_vehicles"
                                class="input-text  @error('registration_number') is-invalid @enderror"
                                name="number_of_vehicles" placeholder="Enter Number Of Vehicles"
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="{{ old('number_of_vehicles') }}">
                        </div>
                        <div class="field required">
                            <label class="label"><span>Travel Agencies Mobile number</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="mobile" class="input-text  @error('mobile') is-invalid @enderror"
                                name="mobile" placeholder="Enter Mobile Number" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="{{ old('mobile') }}">
                            <span id="unique-mob-error" style="display: none; color: red;  font-size: 12px;">This Mobile
                                Number is Already
                                Exists</span>
                        </div>
                        <div class="field required">
                            <label class="label"><span>Travel Agencies Email (optional)</span></label>
                            <input type="text" id="email" class="input-text" name="email" placeholder="Enter Email(optional)"
                                onkeyup="primaryEmail(this.value)" value="{{ old('email') }}">
                            <span style="color: red;" id="primaryEmailError"></span>
                            <span id="unique-email-error" style="display: none; color: red;  font-size: 12px;">This Email is Already  Exists</span> 
                            @error('email')
                                <p style="color: red; font-size: 12px;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="fieldset">
                            <div class="field required">
                                <label class="label"><span>Enter Password</span><span
                                        class="requard">*</span></label>
                                <input type="password" id="password"
                                    class="input-text @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter Password">
                                @error('password')
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>must contain at least one lowercase letter</li>
                                            <li>must contain at least one uppercase letter</li>
                                            <li>must contain at least one digit</li>
                                            <li>must contain a special character</li>
                                            <li>Password must be 7 characters long</li>
                                        </ul>
                                    </div>
                                @enderror
                            </div>
                            <div class="field required">
                                <label class="label"><span>Enter Confirm password</span><span
                                        class="requard">*</span></label>
                                <input type="password" id="password-confirm" class="input-text"
                                    name="password_confirmation" placeholder="Enter Confirm Password">

                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" id="submit" class="btn submit btn-primary" name="send">submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script type="text/javascript" src="{{ asset('front/js/jquery.passwordstrength.js') }}"></script>
<script>
    $(function() {
        $("#password").passwordStrength();
    });

    function primaryEmail(primaryemail) {
        var email = primaryemail;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {
            $("#primaryEmailError").text('Please enter valid email');
            $("#submit").attr("disabled", true);
        } else {
            if ($("#unique-mob-error").css('display') == 'block' || $("#unique-reg-error").css('display') == 'block') {
                $("#primaryEmailError").text('');
                $("#submit").removeAttr("enable");
            } else {
                $("#primaryEmailError").text('');
                $("#submit").removeAttr("disabled");
            }
        }
    }
    jQuery('#travel_reg').validate({
        rules: {
            agency_name: {
                required: true,
                minlength: 3,
                maxlength: 35,
            },
            registration_number: {
                required: true,
                minlength: 7,
                maxlength: 25,
            },
            number_of_vehicles: "required",
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10,
            },
            password: {
                required: true,
                minlength: 7,
                maxlength: 25,
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            agency_name: {
                required: "Please enter your travel agencies name",
            },
            registration_number: {
                required: "Please enter your trade license number",
                number: "Please enter only number"
            },
            number_of_vehicles: {
                required: "Please enter number of vehicles you have",
                number: "Please enter only number"
            },
            mobile: {
                required: "Please enter your mobile Number",
                number: "Please enter only number",
                minlength: "Please enter valid mobile number",
                maxlength: "Please enter valid mobile number"
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be 7 characters long",
            },
            password_confirmation: {
                required: "Re-enter your password",
                equalTo: "The password you have entered does not match.",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#mobile').on('keyup change', function() {
        var mobile = this.value;
        var url = "{{ route('uniqueMobileNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                mobile: mobile,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-mob-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-mob-error").css('display', 'none');
                    if ($("#unique-reg-error").css('display') == 'block' || $("#unique-email-error").css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer');
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });
    $('#email').on('keyup change', function() {
        var email = this.value;
        var url = "{{ route('uniqueEmailNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                email: email,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-email-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-email-error").css('display', 'none');
                    if ($("#unique-reg-error").css('display') == 'block' || $("#unique-mob-error").css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer');
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });
    $('#registration_number').on('keyup change', function() {
        var registration_number = this.value;
        var url = "{{ route('uniqueRegNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                registration_number: registration_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-reg-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-reg-error").css('display', 'none');
                    if ($("#unique-mob-error").css('display') == 'block' || $("#unique-email-error").css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer');
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }

                }
            },
        });
    });
</script>
@include('front.include.footer')
