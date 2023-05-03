@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<section class="dashboard mb-5">

    <div class="container travel-booking driver-availability-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
                @if (session()->has('booking'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('booking') }}
                    </div>
                @elseif (session()->has('block'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('block') }}
                    </div>
                @endif
                <h1 class="title">Book My Availability </h1>
                <div class="box">
                    <div class="box-content">
                        <form id="booking" method="POST" action="{{ url('edit-booking-agency') }}">
                            @csrf
                            <input type="hidden" name="bookingId" value="{{$bookingId}}">
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required ui-widget">
                                <label class="label"><span>Available Location</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="start_location" class="typeahead input-text"
                                    name="start_location"  onChange="checkLocation(this.value)"  placeholder="" value="{{ $booking->startLocation }}">
                                <span id="startSpinner" style="display: none;margin-left: -29px;">
                                    <i class="fa fa-spinner"></i>
                                </span>
                                <div class="form-select" id="locationsearch" style="color: red;font-size: 12px;">
                                </div>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Return Location</span><span
                                        class="requard">*</span></label>
                                <input type="text"  onChange="checkEndLocation(this.value)"  id="end_location" class="input-text" name="end_location"
                                    placeholder="" value="{{ $booking->endLocation }}">
                                <span id="startSpinnerEnd" style="display: none;margin-left: -29px;">
                                    <i class="fa fa-spinner"></i>
                                </span>
                                <div class="form-select" id="locationsearch2" style="color: red;font-size: 12px;">
                                </div>
                            </div>
                            {{-- calander --}}
                            <div class="field required w-100">
                                <label class="label mb-0" class="booking_dates" id="availabe-text"
                                    style="width: 100%"><span>Available
                                        Duration</span><span class="requard">*</span></label>
                                <div class="w-100">
								 <div class="field">
                                    <input type="text" data-format="yyyy-MM-dd" readonly class="booking_dates" id="start_time"
                                        name="start_time" value="{{date('d-m-Y H:i',strtotime($booking->start_time))}}" class="mt-2"  autocomplete="off">
										</div>
                                    <span class="to" style="margin:0px 45px;">to</span>
									 <div class="field">
                                    <input type="text" readonly  class="booking_dates" id="end_time" name="end_time"
                                        value="{{date('d-m-Y H:i',strtotime($booking->end_time))}}" class="mt-2"  autocomplete="off">
										</div>
                                </div>
                            </div>
                            {{-- calander --}}
                            <input type="hidden" name="strtLocId" id="strtLocId"
                                value="{{ $booking->start_location_id }}">
                            <input type="hidden" name="endLocId" id="endLocId" value="{{ $booking->end_location_id }}">
                            <div class="field required">
                                <label class="label"><span>Select Driver for this trip</span><span
                                        class="requard">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="driverUserId"
                                    id="name" onchange="myFunctionnew(this.value)">
                                    <option selected value="" disabled="disabled">Select Driver</option>
                                    @foreach ($driver as $list)
                                        <option value="{{ $list->user_id }}" @if ($list->id == $booking->driver_id) selected  @endif>
                                            {{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field required">
                                <label class="label"><span>Driver Phone Number</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="mobile" class="input-text" name="mobile" placeholder=""
                                    readonly value="">
                            </div>
                            <div class="field required last">
                                <label class="label"><span>Select Vehicle</span><span
                                        class="requard">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="vehicle_type"
                                    id="vehicle_type" >
                                    <option selected disabled value="">Select Vehicle</option>
                                    @foreach ($vehicle as $vehicletype)
                                        <option value="{{ $vehicletype->vehicleId }}" @if ($vehicletype->vehicleId == $booking->vehicle_id) selected  @endif>
                                            {{ $vehicletype->vehicleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="role" value="1">
                            <div class="actions">
                                <button type="submit" class="btn submit btn-primary" id="bookingBtn" name="send">submit</button>
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
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script>
    $(document).ready(function() {
        var date = new Date();
        var addDays = date.setDate(date.getDate() + 6);
        /*$('.booking_dates').datetimepicker({
            format:'dd-mm-yyyy hh:ii',
            startDate: new Date(),
            endDate: new Date(addDays),
            autoclose: true,
        });*/
        $('#start_time').datetimepicker({
            format:'dd-mm-yyyy hh:ii',
            startDate: new Date(),
            endDate: new Date(addDays),
            autoclose: true,
        });
        $('#end_time').datetimepicker({
            format:'dd-mm-yyyy hh:ii',
            startDate: new Date(),
            endDate: new Date(addDays),
            autoclose: true,
        });
    });

    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    
    jQuery('#booking').validate({

        rules: {

            start_location: {
                required: true,

            },
            start_time: {
                required: true,
            },

            end_time: {
                required: true,

            },
            end_location: {
                required: true,
            },
            driverUserId: {
                required: true,
            },
            vehicle_type: {
                required: true,
            },


        },
        messages: {
            start_location: {
                required: "Please enter your available location",
            },
            start_time: {
                required: "Please select start time",
            },
            end_time: {
                required: "Please select end time ",

            },
            end_location: {
                required: "Please enter your return location",
            },
            driverUserId: {
                required: "Please select driver name",
            },
            vehicle_type: {
                required: "Please select vehicle",
            },


        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    myFunctionnew($('select[name="driverUserId"]').val());
    function myFunctionnew(id) {
        $.ajax({
            url: "{{ url('fetch-mobile-number') }}",
            type: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(result) {
                $("#mobile").val(result.mobile);

            }
        });
    }

    $(document).ready(function() {
        $("#start_location").autocomplete({

            source: function(request, response) {
                var url = "{{ route('searchlocation') }}";
                $("#startSpinner").fadeIn(500);
                $("#startSpinner").fadeOut(500);
                $.ajax({
                    type: 'GET',
                    url: url, // http method
                    data: {
                        term: request.term,
                        startLocationId : $("#endLocId").val(),
                        startLocationName: $("#end_location").val(),
                    },
                    dataType: "json",
                    success: function(data) {

                        var resp = $.map(data, function(obj) {

                            return obj.location;
                        });
                        if (resp != '') {
                            $("#locationsearch").text('');
                            var respId = $.map(data, function(obj) {
                                return obj.id;
                            });
                            $("#strtLocId").val(respId);
                            response(resp);
                            $("#bookingBtn").attr("disabled", false);

                        } else {
                            $("#strtLocId").val('');
                            $("#locationsearch").text("NO LOCATION FOUND");
                            $("#bookingBtn").attr("disabled", true);
                        }
                    }
                });
            },
            minLength: 2
        });
    });

    $(document).ready(function() {
        $("#end_location").autocomplete({

            source: function(request, response) {
                var url = "{{ route('searchlocation') }}";
                $("#startSpinnerEnd").fadeIn(500);
                $("#startSpinnerEnd").fadeOut(500);
                $.ajax({
                    type: 'GET',
                    url: url, // http method
                    data: {
                        term: request.term,
                        startLocationId : $("#strtLocId").val(),
                        startLocationName: $("#start_location").val(),
                    },
                    dataType: "json",
                    success: function(data) {

                        var resp = $.map(data, function(obj) {
                            return obj.location;
                        });
                        if (resp != '') {
                            var respId = $.map(data, function(obj) {
                                return obj.id;
                            });
                            $("#endLocId").val(respId);

                            response(resp);
                            $("#locationsearch2").text('');
                            $("#bookingBtn").attr("disabled", false);
                        } else {
                            $("#endLocId").val('');
                            $("#locationsearch2").text("NO LOCATION FOUND");
                            $("#bookingBtn").attr("disabled", true);
                        }
                    }
                });
            },
            minLength: 2
        });
    });


    $('#start_time').on('change', function() {
        let val = Number($(this).val());
        $('#end_time option').each(function() {
            $(this).prop('disabled', Number($(this).val()) <= val)
        })
    });

    function checkLocation(value) {
        $.ajax({
            url: "{{ url('fetch-location') }}",
            type: "POST",
            data: {
                value: value,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                if (data == '1') {
                    if($("#locationsearch2").text() != "")
                    {
                        $("#bookingBtn").attr("disabled", true);
                    }
                    else
                    {
                        $("#bookingBtn").attr("disabled", false);
                    }
                } else {
                    $("#locationsearch").text("No location found");
                    $("#bookingBtn").attr("disabled", true);
                }
            },
        });
    }

    function checkEndLocation(value) {
        $.ajax({
            url: "{{ url('fetch-location') }}",
            type: "POST",
            data: {
                value: value,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                if (data == '1') {
                    if($("#locationsearch").text() != "")
                    {
                        $("#bookingBtn").attr("disabled", true);
                    }
                    else
                    {
                        $("#bookingBtn").attr("disabled", false);
                    }
                } else {
                    $("#locationsearch2").text("No location found");
                    $("#bookingBtn").attr("disabled", true);
                }
            },
        });
    }
</script>
@include('front.include.footer')
