@include('front.include.header')
<section class="dashboard mb-5">
    <div class="container travel-booking driver-availability-dashboard car-info">
        <div class="row">
            @include('front.include.sidebar')
            <div class="col-right">

                <h1 class="title">My vehicle info</h1>
                <div class="box">
                    @if (session()->has('error'))
                        <div class="alert alert-danger message">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="box-content">

                        <form method="POST" id="driverCarInfo" action="{{ url('update-driver-car-info') }}">
                            @csrf
                            <input type="hidden" id="vehicleId" name="vehicleId" value="{{$vehicle->id}}">
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required">
                                <label class="label"><span>Vehicle Registration Number</span><span
                                        class="requard">*</span></label>
                                <input type="text" style="text-transform:uppercase" id="vehicle_registration_number"
                                    class="input-text" name="vehicle_registration_number" placeholder=""
                                    value="{{ $vehicle->vehicle_registration_number }}">
                                <span id="unique-car-error" style="display: none; color: red;">This Vehicle Number is
                                    Already
                                    Exists</span>
                            </div>
                            <div class="field required">
                                <label class="label"><span>per/km rate</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="rate_per_km" class="input-text" name="rate_per_km"
                                    placeholder="" value="{{ $vehicle->rate_per_km }}" min="1" max="99"  onkeyup="this.value=this.value.replace(/[^0-9]/gi, '');">
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Vehicle type</span><span
                                        class="requard">*</span></label>
                                <select class="form-select" aria-label="Default select example" id="vehicle_name"
                                    name="vehicle_name">
                                    <option selected="" value="" disabled="disabled">Select Your Car</option>
                                    @foreach ($vehicleType as $list)
                                        <option value="{{ $list->id }}" @if ($list->id == $vehicle->vehicle_type_id) selected  @endif>
                                            {{ $list->vehicle_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Seat Capacity</span><span
                                        class="requard">*</span></label>
                                <select name="capacity" class="form-select" aria-label="Default select example">
                                    <option selected="" value="" disabled="disabled">Select Seat Capacity</option>
                                    <option value="4+1" @if ($vehicle->capacity == '4+1') selected  @endif>4+1</option>
                                    <option value="6+1" @if ($vehicle->capacity == '6+1') selected  @endif>6+1</option>
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


            vehicle_name: {
                required: true,
            },

            rate_per_km: {
                required: true,
                number: true
            },
            seat_capacity1: {
                required: true,
            },

        },
        messages: {

            vehicle_name: {
                required: "Please Select Your Vehicle Type",
            },
            rate_per_km: {
                required: "Please Enter Your per/km Rate",
                number: "Please Enter Only Number"
            },
            seat_capacity1: {
                required: "Please Select Capacity",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // var readOnlyLength = $('#vehicle_registration_number').val().length;

    // $('#output').text(readOnlyLength);

    // $('#vehicle_registration_number').on('keypress, keydown', function(event) {
    //     var $vehicle_registration_number = $(this);
    //     $('#output').text(event.which + '-' + this.selectionStart);
    //     if ((event.which != 37 && (event.which != 39)) &&
    //         ((this.selectionStart < readOnlyLength) ||
    //             ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
    //         return false;
    //     }
    // });

    $('#vehicle_registration_number').on('keyup change', function() {
        var vehicle_registration_number = this.value;
        var vehicleId = $("#vehicleId").val();
        var url = "{{ route('uniqueCarNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                vehicle_registration_number: vehicle_registration_number,
                vehicleId:vehicleId,
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
</script>
@include('front.include.footer')
