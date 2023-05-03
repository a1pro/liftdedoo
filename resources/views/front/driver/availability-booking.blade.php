@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<div class="overlay"></div>
<section class="dashboard mb-5">

    <div class="container travel-booking driver-availability-dashboard">
        <div class="row">
            @include('front.include.sidebar')
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
                @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @elseif (session()->has('block'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('block') }}
                    </div>
                @endif
                
                @if($driverId->mobile_verify_status == "1")
                <h1 class="title">Book My Availability</h1>
                <div class="input-group search-date">
				<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                    <form method="POST" action="{{ url('search-driver-availability-booking') }}">
                        @csrf
                        @if (count($booking) > 0)
                        <div class="input-group-append">
                            <input type="text" class="form-control" required placeholder="Search With Vehicle Registration Number"
                                name="search" id="search">

                            <button class="btn btn-secondary" type="submit" id="search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                       @endif
                    </form>
					</div>
					</div>

                    @if (count($booking) > 0)
                    <a href="{{ url('driverside-availability-booking') }}"> <button type="button"
                            class="btn btn-secondary" aria-haspopup="true" aria-expanded="false"
                            style="margin-left:10px; border-color:#f42e00;background:#f42e00;">
                            Add More Booking
                        </button></a>
                    @endif
                </div>
				</div>
                <div class="box">
                  
                    @if (count($booking) > 0)

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
                                        <th scope="col">Vehicle Registration Number</th>
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
                                        $start_time = Carbon\Carbon::createFromFormat('Y-m-d H:i', $list->start_time)->format('d-m-Y H:i');
                                        $end_time = Carbon\Carbon::createFromFormat('Y-m-d H:i', $list->end_time)->format('d-m-Y H:i');
                                        $vehicleName = App\Models\VehicleType::getVehicleName($list->vehicle_id);?>
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <?php ?>
                                            <td>{{$start_time}}</td>
                                            <td>{{ $end_time }}</td>
                                            <td>{{ $list->startLocation }}</td>
                                            <td>{{ $list->endLocation }}</td>
                                            <td>{{ $vehicleName}}</td>
                                            <td>{{ $list->vehicleRegistartionNumber}}</td>
                                            <td>
                                                <a
                                                    href="{{ url('edit-driver-book-availability') }}/{{ $list->id }}"><button
                                                        type="button" class="btn btn-info waves-effect waves-light"
                                                        data-effect="wave"><i class="fa fa-pencil-square-o"
                                                            aria-hidden="true"></i></button></a>
                                                <a
                                                    href="{{ url('driver-book-availability/delete') }}/{{ $list->id }}">
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
                    @else
                        <div class="box-content">
                            <form id="booking" method="POST" action="{{ url('Add-booking') }}">
                                @csrf
                                <p class="mandatory">(<em>*</em>) mandatory fields</p>
                                <div class="field required ui-widget">
                                    <label class="label"><span>Available Location</span><span
                                            class="requard">*</span></label>
                                    <input type="text"  onChange="checkLocation(this.value)"id="start_location" class="typeahead input-text"
                                        name="start_location" placeholder="">
                                    <span id="startSpinner" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span>
                                    <div class="form-select" id="locationsearch" style="color: red;font-size: 12px;">
                                    </div>
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Return location</span><span
                                            class="requard">*</span></label>
                                    <input type="text" onChange="checkEndLocation(this.value)" id="end_location" class="input-text" name="end_location"
                                        placeholder="">
                                    <span id="startSpinnerEnd" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span>
                                    <div class="form-select" id="locationsearch2"
                                        style="color: red;font-size: 12px;">
                                    </div>
                                </div>
                                {{-- calander --}}
                                <div class="field required w-100">
                                    <label class="label mb-0" class="booking_dates" id="availabe-text"
                                        style="width: 100%"><span>Available
                                            Duration</span><span class="requard">*</span></label>
                                    <div class="w-100">
									<div class="field">
                                        <input type="text" data-format="dd-MM-yyyy" class="booking_dates"
                                            id="start_time" readonly name="start_time" value="" class="mt-2"
                                            autocomplete="off">
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

                                <div class="field required last">
                                    <label class="label"><span>Select Vehicle</span><span
                                            class="requard">*</span></label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="vehicle_type" id="vehicle_type">
                                        <option selected disabled="" value="">Select Vehicle</option>
                                        @foreach ($vehicle as $vehicletype)
                                            <option value="{{ $vehicletype->vehicleId }}">
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
                    @endif
                </div>
                @else
                    <p class="error-massage">To book your availability, please verify mobile number from account page</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
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
                required: "Please select rriver name",
            },
            vehicle_type: {
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
                        startLocationId: $("#endLocId").val(),
                        startLocationName: $("#end_location").val(),
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        var resp = $.map(data, function(obj) {
                            return obj.location;
                        });
                        if (resp != '') {
                            var respId = $.map(data, function(obj) {
                                return obj.id;
                            });
                            $("#strtLocId").val(respId);
                            response(resp);
                            $("#locationsearch").text('');
                            $("#bookingBtn").attr("disabled", false);
                        } else {
                            $("#strtLocId").val('');
                            $("#locationsearch").text("NO LOCATION FOUND");
                            $("#bookingBtn").attr("disabled", true);
                        }
                    }
                });
            },
            minLength: 2,
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
                        startLocationId: $("#strtLocId").val(),
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
            minLength: 2,
        });
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
