@include('front.include.header')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="contact mb-5">
    <div class="container driver-main">
        <div class="row">
            <h1 class="title text-center">Driver Registration</h1>
            <div class="wrapper">
                <div id="formContent">
                    <form id="register" method="POST" action="{{ url('dashboard') }}">
                        @csrf
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>
                        <div class="field required">
                            <label class="label"><span>{{ __('Name') }}</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="name" class="input-text @error('name') is-invalid @enderror" 
                                name="name" placeholder="Enter Name" value="{{ old('name') }}" autocomplete="name" autofocus
                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                        </div>
                        <div class="field required">

                            <label class="label"><span>Date Of Birth</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="dateOfBirth" name="date_of_birth"
                                onchange="myFunctionterm(this.value)" readonly placeholder="Select Date" autocomplete="off">
                            <span id="age" style=" font-size: 12px;"></span>
                        </div>
                        <div class="field required last">
                            <label class="label"><span>Sex</span><span class="requard">*</span></label>
                            <select class="form-select droup required" aria-label="Default select example"
                                name="gender">
                                <option selected="" value="" disabled="disabled">Select Your Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="field required">
                            <label class="label"><span>Mobile number</span><span
                                    class="requard">*</span></label>
                            <input type="text" id="mobile" class="input-text @error('mobile') is-invalid @enderror"
                                name="mobile" placeholder="Enter Mobile Number" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"
                                value="{{ old('mobile') }}">

                            <span id="unique-mob-error" style="display: none; color: red; font-size: 12px;">This Mobile
                                Number Already
                                Exist</span>
                        </div>
                        <div class="field required">
                            <label class="label"><span>License number</span><span
                                    class="requard">*</span></label>
                            <input type="text" style="text-transform:uppercase" id="license_number" value="WB"
                                class="input-text @error('license_number') is-invalid @enderror" name="license_number"
                                placeholder="" onkeyup="this.value=this.value.replace(/[^a-z0-9 /-]/gi, '');"
                                value="{{ old('license_number') }}">

                            <span id="unique-lic-error" style="display: none; color: red; font-size: 12px;">This License Number is Already Exists</span>
                        </div>
                        <input type="hidden" name="role" value="1">
                        <div class="fieldset">
                            <div class="field required">
                                <label class="label"><span>{{ __('Password') }}</span><span
                                        class="requard">*</span></label>
                                <input type="password" id="password"
                                    class="input-text @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter Password" autocomplete="new-password">
                                @error('password')
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>must contain at least one lowercase letter</li>
                                            <li>must contain at least one uppercase letter</li>
                                            <li>must contain at least one digit</li>
                                            <li>must contain a special character</li>
                                        </ul>
                                    </div>
                                @enderror
                            </div>
                            <div class="field required">
                                <label class="label"><span>{{ __('Confirm Password') }}</span><span
                                        class="requard">*</span></label>
                                <input type="password" id="password-confirm" class="input-text"
                                    name="password_confirmation" placeholder="Enter Confirm Password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" id="submit" class="btn submit btn-primary"
                                name="send">{{ __('Register') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script> -->
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
            if ($("#unique-lic-error").css('display') == 'block' || $("#unique-car-error")
                .css('display') == 'block' || $("#unique-mob-error").css('display') == 'block') {
                $("#primaryEmailError").text('');
                $("#submit").removeAttr("enable");
            } else {
                $("#primaryEmailError").text('');
                $("#submit").removeAttr("disabled");
            }

        }
    }
    jQuery('#register').validate({

        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 25,
            },

            date_of_birth: "required",
            gender: "required",
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            license_number: {
                required: true,
                minlength: 9,
                maxlength: 15,
            },
            car_number: {
                required: true,

            },
            vehicle_type: {
                required: true,
            },

            rate: {
                required: true,
                number: true
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
            name: {
                required: "Please enter your name",
            },

            date_of_birth: {
                required: "Please enter your date of birth",
            },
            gender: "Please select your sex",
            mobile: {
                required: "Please enter your mobile number",
                number: "Please enter only number",
                minlength: "Please enter valid mobile number",
                maxlength: "Please enter valid mobile number"
            },
            license_number: {
                required: "Please enter your license number",
                minlength: "Please enter atleast 9 characters"
            },
            car_number: {
                required: "Please enter your vehicle number",
            },
            vehicle_type: {
                required: "Please select your vehicle type",
            },
            rate: {
                required: "Please enter vehicle per/km rate",
                number: "Please enter only number"
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be 7 Characters Long",
            },
            password_confirmation: {
                required: "Required confirm password",
                equalTo: "The Password You entered does not match.",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    var readOnlyLength = $('#license_number').val().length;

    $('#output').text(readOnlyLength);

    $('#license_number').on('keypress, keydown', function(event) {
        var $license_number = $(this);
        $('#output').text(event.which + '-' + this.selectionStart);
        if ((event.which != 37 && (event.which != 39)) &&
            ((this.selectionStart < readOnlyLength) ||
                ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
            return false;
        }
    });

    $(function() {
        //var dateToday = new Date();
        $('input[id$=dateOfBirth]').datepicker({
            dateFormat: 'dd/mm/yy',
            maxDate: '0',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
            autoclose: true,
            onClose: function() {
                $(this).valid();
            }
        });
        $('#dateOfBirth').datepicker().datepicker();
    });
    function myFunctionterm(data) {
        var now = new Date();
        var past = new Date(data);
        var nowYear = now.getFullYear();
        var pastYear = past.getFullYear();
        var age = nowYear - pastYear;
        if (age < 18) {
            $('#age').html("<span class='text-danger'>Your age should be equal or above 18 years</span>");
            $("#submit").attr('disabled', true);
        }
        else if (age > 60) {
            $('#age').html("<span class='text-danger'>Your age should be below 60 years</span>");
            $("#submit").attr('disabled', true);
        } else {
            $('#age').html(" ");
            $("#submit").removeAttr('disabled');
        }
    }
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
                    if ($("#unique-lic-error").css('display') == 'block' || $("#unique-car-error")
                        .css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer')
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });

    $('#license_number').on('keyup change', function() {
        var license_number = this.value;
        var url = "{{ route('uniqueLicenseNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                license_number: license_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-lic-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-lic-error").css('display', 'none');
                    if ($("#unique-mob-error").css('display') == 'block' || $("#unique-car-error")
                        .css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer')
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });

    $('#car_number').on('keyup change', function() {
        var car_number = this.value;
        var url = "{{ route('uniqueCarNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                car_number: car_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-car-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-car-error").css('display', 'none');
                    if ($("#unique-mob-error").css('display') == 'block' || $("#unique-lic-error")
                        .css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer')
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
