@include('front.include.header')
<section class="dashboard mb-5">

    <div class="container driver-availability-dashboard">
        <div class="row">
            @include('front.include.sidebar')
            <div class="col-right">
                <h1 class="title">Edit Driver Details</h1>

                <div class="box">
                @if (session()->has('error'))
                    <div class="alert alert-danger message">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('error') }}
                    </div>
                @endif
                    <div class="box-content">
                        <form id="edit_driver" method="POST" action="{{ route('drivr_update') }}">
                            @csrf
                            <div class="field required">
                                <label class="label"><span>Name</span></label>
                                <input type="text" id="name" value="{{ $driver->name }}" class="input-text"
                                    name="name" placeholder=""
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                            </div>
                            <label id="name-error" class="error" for="name"
                                style="display: block; padding-left: 210px;"></label>
                            <div class="field required">
                                <label class="label"><span>Date Of Birth</span></label>
                                <input type="text" id="age" class="input-text" value="{{Carbon\Carbon::createFromFormat('Y-m-d', $driver->dob)->format('d/m/Y')   }}" name="age" placeholder="" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" readonly>
                            </div>
                            <label id="age-error" class="error" for="age"
                                style="display: block; padding-left: 210px;"></label>
                            <div class="field required">
                                <label class="label"><span>Sex</span></label>
                                <select class="form-select" aria-label="Default select example" name="gender">

                                    <option value="male" @if ($driver->gender == 'male') selected @endif>Male</option>
                                    <option value="female" @if ($driver->gender == 'female') selected @endif>Female</option>
                                </select>
                            </div>
                            <label id="gender-error" class="error" for="gender"
                                style="display: block; padding-left: 210px;"></label>
                            <div class="field required">
                                <label class="label"><span>Mobile Number</span></label>

                                <input type="text" id="mobile" value="{{ $user->mobile }}" class="input-text"
                                    name="mobile" placeholder="" >
                            </div>
                            <div class="field required">
                                <label class="label"><span>License number</span></label>
                                <input type="text" id="license_number" value="{{ $driver->license_number }}"
                                    class="input-text" name="license_number" placeholder=""
                                    onkeyup="this.value, '')" >

                            </div>
                            <label id="license_number-error" class="error" for="license_number"
                                style="display: block; padding-left: 210px;"></label>
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
    $(".alert.message").fadeTo(2000, 1000).slideUp(1000, function() {
        $(".alert").slideUp(1000);
    });
    jQuery('#edit_driver').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength:25,
            },
            // age: {
            //     required: true,
            //     number: true,
            // },
            gender: "required",
            license_number: {
                required: true,

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
        },
        messages: {
            name: {
                required: "Please enter your name",
            },
            // age: {
            //     required: "Please Enter Your Age",
            //     number: "Please Enter Only Number",
            // },
            gender: "Please enter your sex",

            license_number: {
                required: "Please enter your license number",
            },
            car_number: {
                required: "Please enter your vehilce Rrgistration number",
            },
            vehicle_type: {
                required: "Please enter your vehicle type",
            },
            rate: {
                required: "Please enter your vehicle rate/km ",
                number: "Please enter only number"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@include('front.include.footer')
