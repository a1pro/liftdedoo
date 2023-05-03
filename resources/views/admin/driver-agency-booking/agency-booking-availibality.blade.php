@include('admin.header')
<!-- Begin Left Navigation -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@include('admin.sidebar')
<!-- Left Navigation End -->
<!-- Begin main content -->
<div class="main-content">
    <!-- content -->
    <div class="page-content">
        <!-- page header -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="page-title dflex-between-center">
                    <h3 class="mb-1 font-weight-bold">Agency Booking Form</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">
                                AgencyBookingTable
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Agency Booking Form</li>
                    </ol>
                </div>
                <a href="{{url('users-list')}}">
                    <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                </a>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            @if (session()->has('booking'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('booking') }}
                            </div>
                            @endif
                            <div class="card-body">
                                <form id="vehicle" class="needs-validation" method="POST"
                                    action="{{ url('add-admin-agency-booking') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                    <input type="hidden" name="agencyId" value="{{$agencyId}}">
                                        <label for="validation-fname">Available Location</label>
                                        <input type="text" class="form-control" id="start_location"
                                            placeholder="Available Location" name="start_location" value="">
                                        <div class="form-select" id="locationsearch"
                                            style="color: red;font-size: 12px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Destination Location</label>
                                        <input type="text" class="form-control" id="end_location"
                                            placeholder="Destination Location" name="end_location" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Start Time</label>
                                        <input type="text" class="booking_dates form-control" id="start_time"
                                            placeholder="Start Time" name="start_time" value="" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">End Time</label>
                                        <input type="text" class="booking_dates form-control" id="end_time"
                                            placeholder="End Time" name="end_time" value="" autocomplete="off">
                                    </div>
                                    <input type="hidden" name="strtLocId" id="strtLocId">
                                    <input type="hidden" name="endLocId" id="endLocId">
                                    <div class="form-group">
                                        <label for="example-select">Select Driver for this trip</label>
                                        <select class="form-control" id="name" name="driverUserId"
                                            onchange="myFunctionnew(this.value)">
                                            <option>Select Driver</option>
                                            @foreach ($driver as $list)
                                                <option value="{{ $list->user_id }}">{{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Driver Phone Number</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="mobile"
                                            name="mobile" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-select">Select Vehicle</label>
                                        <select class="form-control" id="vehicle_type" name="vehicle_type">
                                            <option selected="" value="" disabled="disabled">Select Vehicle</option>
                                            @foreach ($vehicle as $vehicletype)
                                            <option value="{{ $vehicletype->vehicleId }}">
                                                {{ $vehicletype->vehicleName }}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="role" value="1">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- main content End -->
@include('admin.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('admin/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('admin/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
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

    function myFunctionnew(id) {
        $.ajax({
            url: "{{ url('fetch-mobile-number-agency') }}",
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
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });


    $(document).ready(function() {
        $("#start_location").autocomplete({
            source: function(request, response) {
                var url = "{{ route('searchcity') }}"
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
                        } else {
                            $("#strtLocId").val('');
                            $("#locationsearch").text("NO LOCATION FOUND");
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
                var url = "{{ route('searchcity') }}"
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
                        } else {
                            $("#endLocId").val('');
                            $("#locationsearch2").text("NO LOCATION FOUND");
                        }
                    }
                });
            },
            minLength: 2,
        });
    });
    jQuery('#vehicle').validate({

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
                required: "Please Enter Your Start Location",
            },
            start_time: {
                required: "Please Select Start Time",
            },
            end_time: {
                required: "Please select End Time ",

            },
            end_location: {
                required: "Please Enter Your End Location",
            },
            driverUserId: {
                required: "Please Select Driver Name",
            },
            vehicle_type: {
                required: "Please Select Vehicle",
            },


        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
