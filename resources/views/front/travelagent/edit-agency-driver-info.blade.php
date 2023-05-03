@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="dashboard mb-5">

    <div class="container travel-booking driver-availability-dashboard car-info">
        <div class="row">
            @include('front.include.agent-sidebar')

            <div class="col-right">
                @if (session()->has('save'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('save') }}
                    </div>
                @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @elseif (session()->has('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('error') }}
                    </div>
                @endif
                

                <h1 class="title">Agencies Driver Details</h1>
                <div class="box">
                    <div class="box-content">
                        <form id="agencyReg" method="POST" action="{{ url('update-agency-driver-info') }}">
                            @csrf
                            
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required">
                                <label class="label"><span>Driver Name</span><span
                                        class="requard">*</span></label>
                                <input type="text" placeholder="" name="name" class="input-text"
                                    value="{{ $driver->name }}" id="name"
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                            </div>
                            <input type="hidden" name="driverId" id="driverId" value="{{$driver->id}}">
                            <div class="field required">
                                <label class="label"><span>Driver Age</span><span
                                        class="requard">*</span></label>
                                <input type="number" placeholder="" min="18" max="60" name="age" id="age"
                                    value="{{ $driver->age }}">
                            </div>
                            <div class="field required">
                                <label class="label"><span>Driver Sex</span><span
                                        class="requard">*</span></label>
                                <select class="form-select droup required" aria-label="Default select example"
                                    name="gender" id="gender">
                                    <option value="male" @if ($driver->gender == 'male') selected @endif>Male</option>
                                    <option value="female" @if ($driver->gender == 'female') selected @endif>Female</option>
                                </select>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Driver Mobile number</span><span
                                        class="requard">*</span></label>
                                <input type="number" placeholder="" name="mobile" class="input-text" id="mobile"
                                onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g, '')"
                                    value="{{ $driver->mobile }}" >
                                <span id="unique-mob-error" style="display: none; color: red;">This Mobile Number is
                                    Already
                                    Exists</span>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Driver License number</span><span
                                        class="requard">*</span></label>
                                <input type="text" placeholder="" name="license_number" class="input-text" style="text-transform: uppercase"
                                    id="license_number" onkeyup="this.value, '')"
                                    value="{{ $driver->license_number }}" >
                                <span id="unique-lic-error" style="display: none; color: red;">This License Number
                                    is
                                    Already Exists</span>
                            </div>
                            <input type="hidden" name="role" value="1">
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
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    jQuery('#agencyReg').validate({

        rules: {

            name: {
                required: true,
            },
            age: {
                required: true,
                number: true,
            },
            gender: {
                required: true,
            },
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

        },
        messages: {

            name: {
                required: "Please enter your driver name",
            },
            age: {
                required: "Please enter your driver age",
                number: "Please enter only number",
            },
            gender: {
                required: "Please enter your sex",
            },
            mobile: {
                required: "Please enter your driver mobile number",
                number: "Please enter only number",
                minlength: "Please enter valid mobile number",
                maxlength: "Please enter valid mobile number"
            },
            license_number: {
                required: "Please enter your driver license number",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#mobile').on('keyup change', function() {
        var mobile = this.value;
        var driverId= $("#driverId").val();
        var url = "{{ route('uniqueMobileNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                mobile: mobile,
                id:driverId,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-mob-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-mob-error").css('display', 'none');
                    if ($("#unique-lic-error").css('display') == 'block') {
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
        var driverId= $("#driverId").val();
        var url = "{{ route('uniqueLicenseNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                license_number: license_number,
                id:driverId,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-lic-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-lic-error").css('display', 'none');
                    if ($("#unique-mob-error").css('display') == 'block') {
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
