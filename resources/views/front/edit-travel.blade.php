@include('front.include.header')
<section class="dashboard mb-5">
    <div class="container driver-availability-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
                <h1 class="title">Edit Agencies Details </h1>
                <div class="box">
                    @if (session()->has('error'))
                        <div class="alert alert-danger message">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="box-content">
                        <form id="edit_travel" method="POST" action="{{ route('travel_update') }}">
                            @csrf
                            <div class="field required">
                                <label class="label"><span>Agencies Name</span></label>
                                <input type="text" id="agency_name" value="{{ $travel->agency_name }}"
                                    class="input-text" name="agency_name" placeholder=""
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                            </div>
                            <label id="agency_name-error" class="error" for="agency_name"
                                style="display: block; padding-left: 210px;"></label>
                            <div class="field required">
                                <label class="label"><span>Agencies Trade License Number</span></label>
                                <input type="text" id="registration_number" class="input-text"
                                    value="{{ $travel->registration_number }}" name="registration_number"
                                    placeholder="" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g, '')"
                                    >
                                <span id="unique-reg-error" style="display: none; color: red;">This registration number
                                    is already exists</span>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Number of vehicles</span></label>
                                <input type="text" id="number_of_vehicles" value="{{ $travel->number_of_vehicles }}"
                                    class="input-text" name="number_of_vehicles" placeholder="" min="1"
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <label id="number_of_vehicles-error" class="error" for="number_of_vehicles"
                                style="display: block; padding-left: 210px;"></label>
                            <label id="registration_number-error" class="error" for="registration_number"
                                style="display: block; padding-left: 210px;"></label>
                            <div class="field required">
                                <label class="label"><span>Mobile Number</span></label>
                                <input type="text" id="mobile" value="{{ $user->mobile }}" class="input-text"
                                    name="mobile" placeholder="" >
                            </div>
                            @if ($user->email != null)
                                <div class="field required">
                                    <label class="label"><span>Email</span></label>
                                    <input type="text" id="email" value="{{ $user->email }}" class="input-text"
                                        name="email" placeholder="" onkeyup="primaryEmail(this.value)">
                                    <span style="color: red;display: block; padding-left: 210px;"
                                        id="primaryEmailError"></span>
                                    <span id="unique-email-error" style="padding-left: 210px;display: none; color: red;  font-size: 12px;">This Email is Already  Exists</span> 
                                </div>
                            @else
                                <div class="field required">
                                    <label class="label"><span>Email</span></label>
                                    <input type="text" id="email" value="" class="input-text" name="email"
                                        placeholder="" onkeyup="primaryEmail(this.value)">
                                    <span style="color: red;display: block; padding-left: 210px;"
                                        id="primaryEmailError"></span>
                                        <span id="unique-email-error" style="padding-left: 210px;display: none; color: red;  font-size: 12px;">This email is already exists</span> 
                                </div>
                            @endif
                            <div class="actions">
                                <button type="submit" id="submit" class="btn submit btn-primary"
                                    name="send">submit</button>
                                <input type="button" class="btn submit btn-primary" onclick="GoBackWithRefresh();return false;" value="Cancel">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--Section: Contact v.2-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
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
    jQuery('#edit_travel').validate({
        rules: {
            agency_name: {
                required: true,
                minlength: 3,
            },
            registration_number: "required",
            number_of_vehicles: {
                required: true,
                number: true
            },
        },
        messages: {
            agency_name: {
                required: "Please Enter Your Agency Name",
            },
            registration_number: {
                required: "Please Enter Your Trade License Number",

            },
            number_of_vehicles: {
                required: "Please Enter Your Number of Vehicles",
                number: "Please Enter Only Number"
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
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
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
@include('front.include.footer')
