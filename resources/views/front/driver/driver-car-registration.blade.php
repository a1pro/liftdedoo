@include('front.include.header')
<section class="dashboard mb-5">
    <div class="container travel-booking driver-availability-dashboard car-info">
        <div class="row">
            @include('front.include.sidebar')
            <div class="col-right">

                <h1 class="title">My vehicle info</h1>
                <div class="box">
                    <div class="box-content">

                        <form method="POST" id="driverCarInfo" action="{{ route('driver.car.info') }}">
                            @csrf
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required">
                                <label class="label"><span>Vehicle Registration Number</span><span
                                        class="requard">*</span></label>
                                <input type="text" value="WB" style="text-transform:uppercase"
                                    id="vehicle_registration_number" class="input-text"
                                    name="vehicle_registration_number" placeholder="">
                                <span id="unique-car-error" style="display: none; color: red;">This Vehicle Number is
                                    Already
                                    Exists</span>
                            </div>
                            <div class="field required">
                                <label class="label"><span>per/km rate</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="rate_per_km" value="" class="input-text" name="rate_per_km"
                                    placeholder="" min="1" max="99"  onkeyup="this.value=this.value.replace(/[^0-9]/gi, '');">
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Vehicle type</span><span
                                        class="requard">*</span></label>
                                <select class="form-select" aria-label="Default select example" id="vehicle_name"
                                    name="vehicle_name">
                                    <option selected="" value="" disabled="disabled">Select Your Car</option>
                                    @foreach ($vehicleType as $list)
                                        <option value="{{ $list->id }}">
                                            {{ $list->vehicle_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field required last">
                                <label class="label"><span>seating Capacity</span><span
                                        class="requard">*</span></label>
                                <select name="capacity" class="form-select" aria-label="Default select example">
                                    <option selected="" value="" disabled="disabled">Select seating Capacity</option>
                                    <option value="4+1">4+1</option>
                                    <option value="6+1">6+1</option>
                                </select>
                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    jQuery('#driverCarInfo').validate({

        rules: {

            vehicle_registration_number: {
                required: true,
                minlength: 8,
                maxlength: 10,
            },
            vehicle_name: {
                required: true,
            },

            rate_per_km: {
                required: true,
                number: true
            },
            capacity: {
                required: true,
            },

        },
        messages: {
            vehicle_registration_number: {
                required: "Please enter your vehicle number",
                minlength: "Minimum 8 characters allowed",
                maxlength: "Maximum 10 characters allowed",
            },
            vehicle_name: {
                required: "Please select your vehicle type",
            },
            rate_per_km: {
                required: "Please enter your vehicle per/km rate",
                number: "Please enter only number"
            },
            capacity: {
                required: "Please select seating capacity",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $('#vehicle_registration_number').on('keyup change', function() {
        var vehicle_registration_number = this.value;
        var url = "{{ route('uniqueCarNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                vehicle_registration_number: vehicle_registration_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-car-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-car-error").css('display', 'none');
                    $("#submit").prop('disabled', false);
                    $("#submit").css('cursor', 'pointer');
                }
            },
        });
    });
    var readOnlyLength = $('#vehicle_registration_number').val().length;

    $('#output').text(readOnlyLength);

    $('#vehicle_registration_number').on('keypress, keydown', function(event) {
        var $vehicle_registration_number = $(this);
        $('#output').text(event.which + '-' + this.selectionStart);
        if ((event.which != 37 && (event.which != 39)) &&
            ((this.selectionStart < readOnlyLength) ||
                ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
            return false;
        }
    });
</script>
@include('front.include.footer')
