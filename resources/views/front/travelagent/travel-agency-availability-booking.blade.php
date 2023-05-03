@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<div class="overlay"></div>
<section class="dashboard mb-5 avilabilty-book">

    <div class="container travel-booking agency-book driver-availability-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
			<div class="title-srch">
                @if (session()->has('booking'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('booking') }}
                    </div>
                    @elseif (session()->has('update'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('update') }}
                    </div>
                    @elseif (session()->has('block'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('block') }}
                    </div>
                    @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @endif
                @if($agencyId->mobile_verify_status == "1")
                    @if (count($booking) > 0)
                    <h1 class="title">Booking Availability Details</h1>
                    @else
                    <h1 class="title">Book My Availability </h1>
                    @endif
                    <div class="input-group search-date">
					<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                            <form method="POST" action="{{ url('search-agency-availability-booking') }}">
                                @csrf
                                @if (count($booking) > 0)
                                <div class="input-group-append">
                                    <input type="text" class="form-control" required placeholder="Search with Driver Phone" name="search"
                                        id="search">

                                    <button class="btn btn-secondary" type="submit" id="search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                @endif
                            </form>
						</div>
						</div>
                         @if (count($booking) > 0)
                            <a href="{{ url('agency-availability-booking') }}"> <button type="button" class="btn btn-secondary" aria-haspopup="true" aria-expanded="false" style="margin-left:10px; border-color:#f42e00;background:#f42e00;"> Add More Booking </button></a>
                         @endif
                        </div>
						</div>
                    <div class="box">
                        @if (count($booking) > 0)
                        
                            <div class="box-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Start Date-Time</th>
                                                <th scope="col">End Date-Time</th>
                                                <th scope="col">Available Location</th>
                                                <th scope="col">Return Location</th>
                                                <th scope="col">Vehicle Name</th>
                                                <th scope="col">driver name</th>
                                                <th scope="col">driver phone</th>
                                                <th scope="col">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($booking as $list)
                                                <?php

                                                if (date('Y-m-d H:i', strtotime($list->end_time)) < date('Y-m-d H:i')) {
                                                    $data = App\Models\Booking\BookingAvailabilty::deleteBoking($list->id);
                                                } 
                                                $vehicleName = App\Models\VehicleType::getVehicleName($list->vehicle_id); ?>
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td>{{date('d-m-Y H:i',strtotime($list->start_time))}}</td>
                                                    <td>{{date('d-m-Y H:i',strtotime($list->end_time))}}</td>
                                                    <td>{{ $list->startLocation }}</td>
                                                    <td>{{ $list->endLocation }}</td>
                                                    <td>{{ $vehicleName}}</td>
                                                    <td>{{ $list->drivername }}</td>
                                                    <td>{{ $list->usermobile }}</td>
                                                    <td>
                                                        <a href="{{url('edit-travel-agent-availability-booking')}}/{{ $list->id }}"><button
                                                            type="button" class="btn btn-info waves-effect waves-light"
                                                            data-effect="wave"><i class="fa fa-pencil-square-o"
                                                                aria-hidden="true"></i></button></a>
                                                    <a
                                                        href="{{url('agency-book-availability/delete')}}/{{ $list->id }}">
                                                        <button type="button"
                                                            class="btn btn-danger waves-effect waves-light"
                                                            data-effect="wave"> <i class="fa fa-trash"
                                                                aria-hidden="true"></i></button></a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="box-content">
                                <form id="booking" method="POST" action="{{ url('Add-booking-agency') }}">
                                    @csrf
                                    <p class="mandatory">(<em>*</em>) mandatory fields</p>
                                    <div class="field required ui-widget">
                                        <label class="label"><span>Available Location</span><span
                                                class="requard">*</span></label>
                                        <input type="text" id="start_location" class="typeahead input-text"
                                            name="start_location" placeholder="" onChange="checkLocation(this.value)">
                                            <span id="startSpinner" style="display: none;margin-left: -29px;">
                                                <i class="fa fa-spinner"></i>
                                            </span>
                                        <div class="form-select" id="locationsearch" style="color: red;font-size: 12px;"></div>
                                    </div>
                                    <div class="field required">
                                        <label class="label"><span>Return Location</span><span
                                                class="requard">*</span></label>
                                        <input type="text" id="end_location" class="input-text" name="end_location" onChange="checkEndLocation(this.value)"
                                            placeholder="">
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
                                            <input type="text" data-format="yyyy-MM-dd" class="booking_dates"
                                                id="start_time" readonly name="start_time" value="" class="mt-2" autocomplete="off">
                                                </div>
                                            <span class="to" style="margin:0px 45px;">to</span>
                                            <div class="field">
                                            <input type="text" readonly class="booking_dates" id="end_time" name="end_time" value=""
                                                class="mt-2" autocomplete="off">
                                                </div>
                                        </div>
                                    </div>
                                    {{-- calander --}}
                                    <input type="hidden" name="strtLocId" id="strtLocId">
                                    <input type="hidden" name="endLocId" id="endLocId">
                                    <div class="field required">
                                        <label class="label"><span>Select Driver for this trip</span><span
                                                class="requard">*</span></label>
                                        <select class="form-select" aria-label="Default select example"
                                            name="driverUserId" id="name" onchange="myFunctionnew(this.value)">
                                            <option selected value="" disabled="disabled">Select Driver</option>
                                            @foreach ($driver as $list)
                                                <option value="{{ $list->user_id }}">{{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field required">
                                        <label class="label"><span>Driver Phone Number</span><span
                                                class="requard">*</span></label>
                                        <input type="text" id="mobile" class="input-text" name="mobile" placeholder=""
                                            readonly>
                                    </div>
                                    <div class="field required last">
                                        <label class="label"><span>Select Vehicle</span><span
                                                class="requard">*</span></label>
                                        <select class="form-select" aria-label="Default select example"
                                            name="vehicle_type" id="vehicle_type">
                                            <option selected="" value="" disabled="disabled">Select Vehicle</option>
                                            @foreach ($vehicle as $vehicletype)
                                            <option value="{{ $vehicletype->vehicleId }}">
                                                {{ $vehicletype->vehicleName }} ({{ $vehicletype->vehicle_registration_number }})</option>
                                            @endforeach
                                        
                                        </select>
                                    </div>
                                    <input type="hidden" name="role" value="1">
                                    <div class="actions">
                                        <button type="submit" id="bookingBtn" class="btn submit btn-primary" name="send">submit</button>
                                        <input type="button" class="btn submit btn-primary" onclick="GoBackWithRefresh();return false;" value="Cancel">
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                @else
                    <p class="error-massage">To book  your availability, please verify mobile number from account page</p>
                @endif
            </div>
        </div>
    </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script>
    $(document).ready(function(){
        $(".slide-toggle").click(function(){
            $(".srch-box").animate({
                width: "toggle"
            });
        });
		
    });
	
</script>
<script>
    $(document).ready(function(){
// flag : says "remove class when click reaches background"
var removeClass = true;

// when clicking the button : toggle the class, tell the background to leave it as is
$(".slide-toggle").click(function () {
    $("body").toggleClass('over');
    removeClass = false;
});
$(".overlay").click(function(){
  $("body").removeClass("over");
  $(".srch-box").css("display", "none");
});
// when clicking the div : never remove the class
$("body").click(function() {
    removeClass = false;
});

// when click event reaches "html" : remove class if needed, and reset flag
$("html").click(function () {
    if (removeClass) {
        $("body").removeClass('over');
    }
    removeClass = true;
});
    });
	
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
            vehicle_type: {
                required: true,
            },
            driverUserId: {
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
            vehicle_type: {
                required: "Please select driver name",
            },
            driverUserId: {
                required: "Please select vehicle",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

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
                            $("#locationsearch").text("No location found");
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
                            $("#locationsearch2").text("No location found");
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
