@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<div class="overlay"></div>
<section class="dashboard mb-5 booking-history">
    <div class="container booking-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
			<div class="title-srch">
                <h1 class="title">booking history</h1>
                <div class="input-group search-date">
                    <div class="input-group-append w-100">
					<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                        <form method="POST" action="{{ route('searchAgencyBookingHistory') }}">
                        @csrf
                            <div class="input-group-append">
                                <input type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" class="form-control" required placeholder="Search With Driver Mobile" name="search"
                                    id="search">

                                <button class="btn btn-secondary" type="submit" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
						</div>
						</div>
                    </div>
                </div>
				</div>
                <div class="box">
                    <div class="box-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Booking Date</th>
                                        <th scope="col">Available Location</th>
                                        <th scope="col">Return Location</th>
                                        <th scope="col">Driver Name</th>
                                        <th scope="col">Driver Phone</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Customer Phone</th>
                                        <th scope="col">Vehicle Name</th>
                                        <th scope="col">Vehicle Registration Number</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Fare</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                <?php $i = 1;
                                         ?>
                                        @if(count($bookingInfo) == 0)
                                            <td colspan="7" class="text-center not-found">No Booking History Found</td>
                                        @else
                                            @foreach ($bookingInfo as $booking)
                                            <?php $vehicleName = App\Models\VehicleType::vehicleName($booking['vehicle_type_id']); 
                                               $bookingId = App\Models\booking_request::addFiveDigitNo($booking['id']);?>
                                               @if ($booking['status']  == 4)
                                                @continue
                                               @endif
                                            <tr>
                                                <td>{{ $bookingId }}</td>
                                                <td>{{date('d-m-Y', strtotime($booking['bookingDate']))}} </td>
                                                <td>{{ $booking['startLocation'] }}</td>
                                                <td>{{ $booking['endLocation'] }}</td>
                                                <td>{{ $booking['driverName'] }}</td>
                                                <td>{{ $booking['driverMobile'] }}</td>
                                                <td>{{ $booking['customer_name'] }}</td>
                                                <td>{{ $booking['customer_mobile_number'] }}</td>
                                                <td>{{ $vehicleName }}</td>
                                                <td>{{ $booking['vehicle_number'] }}</td>
                                                @if ( $booking['payment_option']  == 0)
                                                    <td> 15% Advance Payment </td>
                                                @elseif( $booking['payment_option'] ==1)
                                                    <td> 5% Advance Payment </td>
                                                @endif
                                                <td>{{ $booking['price'] }}</td>
                                                @if ( $booking['status']  == 4)
                                                    <td style="color:orange;">Failed </td>
                                                @elseif( $booking['status'] == 1)
                                                    <td style="color:green;">Confirmed </td>
                                                @elseif( $booking['status'] == 2)
                                                    <td style="color:red;"> Cancelled </td>
                                                @elseif( $booking['status'] == 3)
                                                    <td style="color:red;"> Cancelled </td>
                                                @endif
                                            </tr>
                                            @endforeach
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
@include('front.include.footer')
