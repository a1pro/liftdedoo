@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<div class="overlay"></div>
<section class="dashboard mb-5 search-travel">

    <div class="container travel-booking driver-availability-dashboard">
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
                    @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @endif
               
                <h1 class="title">Booking Availability Details</h1>
               <div class="input-group search-date">
			      <div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                        <form method="POST" action="{{ url('search-agency-availability-booking') }}">
                            @csrf
                            <div class="input-group-append">
                                <input type="text" class="form-control" required placeholder="Search with Driver Phone" name="search"
                                    id="search">

                                <button class="btn btn-secondary" type="submit" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                        </form>
					</div>
					</div>
                        <a href="{{ url('agency-availability-booking') }}"> <button type="button" class="btn btn-secondary" aria-haspopup="true" aria-expanded="false" style="margin-left:10px; border-color:#f42e00;background:#f42e00;"> Add More Booking </button></a>
                    </div>
					</div>
                <div class="box">
                    
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
                                    @if (count($booking) > 0)
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
                                        @else
                                            <td style="text-align:center;"colspan="7">No booking list available</td>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
        $('.booking_dates').datetimepicker({
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
</script>
@include('front.include.footer')
