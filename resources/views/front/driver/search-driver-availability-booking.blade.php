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
                <h1 class="title">Book My Availability</h1>
                <div class="input-group search-date">
				<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                    <form method="POST" action="{{ url('search-driver-availability-booking') }}">
                        @csrf
                        <div class="input-group-append">
                            <input type="text" class="form-control" required placeholder="Search With Vehicle Registration Number"
                                name="search" id="search">

                            <button class="btn btn-secondary" type="submit" id="search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
					</div>
					</div>
                    <a href="{{ url('driverside-availability-booking') }}"> <button type="button"
                            class="btn btn-secondary" aria-haspopup="true" aria-expanded="false"
                            style="margin-left:10px; border-color:#f42e00;background:#f42e00;">
                            Add More Booking
                        </button></a>
                </div>
				</div>
                <div class="box">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Start Date-Time</th>
                                    <th scope="col">End Date-Time</th>
                                    <th scope="col">Available Location</th>
                                    <th scope="col">Destination Location</th>
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
                                        <td>{{ $start_time }}</td>
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
                </div>
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
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
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
@include('front.include.footer')
