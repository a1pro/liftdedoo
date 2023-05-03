@include('front.include.header')
<div class="overlay"></div>
<section class="dashboard mb-5">
    <div class="container booking-dashboard booking-history">
        <div class="row">
            @include('front.include.sidebar')
            <div class="col-right">
			<div class="title-srch">
                <h1 class="title">booking history</h1>
                <div class="input-group search-date">
                <div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                <form method="POST" action="{{ route('searchBookingHistory') }}">
                    @csrf
                    <div class="input-group-append">
                        <input type="text" class="form-control" placeholder="Search With Customer Mobile Number" required name="search" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"
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
                <div class="box">
                    <div class="box-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Booking Id</th>
                                        <th scope="col">customer name</th>
                                        <th scope="col">customer mobile</th>
                                        <th scope="col">Available Location</th>
                                        <th scope="col">Return location</th>
                                        <th scope="col">Vehicle Name</th>
                                        <th scope="col">Vehicle number</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">fare</th>
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
                                                <td>{{ $booking['customer_name'] }}</td>

                                                <td>{{ $booking['customer_mobile_number'] }}</td>
                                                <td>{{ $booking['startLocation'] }}</td>
                                                <td>{{ $booking['endLocation'] }}</td>

                                                <td>{{ $vehicleName }}</td>
                                                <td>{{ $booking['vehicle_number'] }}</td>
                                                @if ( $booking['payment_option']  == 0)
                                                    <td> 15% Advance Payment </td>
                                                @elseif( $booking['payment_option'] ==1)
                                                    <td> 5% Advance Payment </td>
                                                @endif
                                                <td>{{ $booking['price'] }}</td>
                                                @if ( $booking['status']  == 4)
                                                    <td style="color:orange;">Failed</td>
                                                @elseif( $booking['status'] == 1)
                                                    <td style="color:green;">Confirmed </td>
                                                @elseif( $booking['status'] == 2)
                                                    <td style="color:red;"> Cancelled </td>
                                                @elseif( $booking['status'] == 3)
                                                    <td style="color:red;"> Cancelled </td>
                                                @endif
                                            </tr>
                                           <?php $i++; ?>
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
<!--Section: Contact v.2-->
@include('front.include.footer')
