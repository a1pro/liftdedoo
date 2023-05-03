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
                @elseif (session()->has('validity'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('validity') }}
                    </div>
                @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @endif

                <h1 class="title">Register Your Vehicle</h1>
                <div class="box">
                    <div class="box-content">

                        <form id="agencyInfo" method="POST" action="{{ route('agency.car.info') }}">
                            @csrf
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required">
                                <label class="label"><span>Vehicle Registration Number.</span><span
                                        class="requard">*</span></label>
                                <input type="text" value="WB" style="text-transform: uppercase"
                                    id="vehicle_registration_number" class="input-text"
                                    name="vehicle_registration_number" placeholder="" onkeyup="this.value, '')">
                                <span id="unique-car-error" style="display: none; color: red;">This Vehicle Number is
                                    Already
                                    Exists</span>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Vehicle Rate/Km</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="rate_per_km" class="input-text" name="rate_per_km"
                                    placeholder=""  onkeyup="this.value=this.value.replace(/[^0-9]/gi, '');">
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Vehicle Type</span><span
                                        class="requard">*</span></label>

                                <select class="form-select" aria-label="Default select example" name="vehicle_name"
                                    id="vehicle_name">
                                    <option selected="" value="" disabled="disabled">Select Your Vehicle</option>
                                    @foreach ($vehicleType as $list)
                                        <option value="{{ $list->id }}">{{ $list->vehicle_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Seating Capacity</span><span
                                        class="requard">*</span></label>
                                {{-- <select class="form-select" aria-label="Default select example" id="seat_capacity"
                                    name="seat_capacity">
                                    <option selected="" value="" disabled="disabled">Select Seating Capacity</option> --}}
                                {{-- @foreach ($vehicleType as $list)
                                        <option value="{{ $list->id }}">{{ $list->seat_capacity }}</option>
                                    @endforeach --}}
                                <select name="capacity" class="form-select" aria-label="Default select example">
                                    <option selected="" value="" disabled="disabled">Select Seating Capacity</option>
                                    <option value="4+1">4+1</option>
                                    <option value="6+1">6+1</option>
                                </select>
                                {{-- </select> --}}
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
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    jQuery('#agencyInfo').validate({

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
                required: "Please enter your vehicle registration number",
                maxlength:"Maximum 10 characters allowed",
            },
            vehicle_type: {
                required: "Please select your vehicle type",
            },
            rate_per_km: {
                required: "Please enter your vehicle rate/km ",
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
