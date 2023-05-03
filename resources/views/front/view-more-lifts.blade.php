@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
  
    #loading {
     display: none;       
     position: absolute;   
     top: 0;                 
     right: 0;              
     bottom: 0;
     left: 0;
    }
    #loading-image {
      background: url({{url('/')}}/images/load.gif) center center no-repeat;
      height: 100%;
      z-index: 20;
      width: 100%;
      top: 0px;
      left: 0px;
      position: fixed;
    }

  .set-filters-wrapper {
    margin-bottom: 1px;
}
.filterdata {
    list-style: none;
    margin: 0;
    padding: 0;
    border: 0;
}
.set-filters {
    background-color: #7d7d7d;
    color: #3e3e52;
    font-weight: 700;
    padding: 8px 28px 8px 10px;
    cursor: pointer;
    position: relative;
    margin: 5px 0;
    margin-right: 10px;
    border-radius: 3px;
    background-color: #f8f4f4;
}
.set-filters, .truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.fl {
    float: left;
}
.set-filter-close {
    position: absolute;
    right: 7px;
    top: 10px;
    color: #3e3e52;
    font-size: 20px;
}
.close {
  cursor: pointer;
  position: absolute;
  top: 50%;
  right: 0%;
  padding: 12px 16px;
  transform: translate(0%, -50%);
}

.close:hover {background: #bbb;}
</style>
<div id="search-modl" class="search-modal view-more-search">
   <div class="container relative">
    <div class="row">  
	<button class="modify-btn" onclick="openNav2('searchmodal', 'search-modl')">Search<i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
   </div>
</div>
<div id="searchmodal" class="search-page-form mt-3 mb-2 view-more-modal">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav2('searchmodal')">&times;</a>
    <div class="container relative text-center">

        <div id="date-picker-example" class="banner-search md-form md-outline input-with-post-icon datepicker" inline="true">
		
            <form method="POST" id="searchForm" action="{{ url('search') }}">
                @csrf
				<div class="field1">
                <div class="field">
				  <span class="field-txt">From</span>
                    <input placeholder="Current location" value="" autocomplete="off" type="text" id="start_location" name="start_location" class="form-control" required onChange="checkLocation(this.value)">
                    <span class="form-select" id="locationsearch" style="color: red;font-size: 12px;"></span>
                </div>
				<span class="exchng-icon"><i class="fa fa-exchange" aria-hidden="true"></i></span>
                <div class="field last">
				<span class="field-txt">To</span>
                    <input type="hidden" name="strtLocId" id="strtLocId">
                    <input placeholder="Destination" value="" autocomplete="off" type="text" id="end_location" name="end_location" class="form-control" required onChange="checkEndLocation(this.value)">
                    <span class="form-select" id="locationsearch2" style="color: red;font-size: 12px;"></span>
                </div>
				</div>
				<div class="field2">
                <div class="field">
				 <span class="field-txt">Date</span>
                    <input type="hidden" name="endLocId" id="endLocId">
                    <input placeholder="Date of journey" value="" type="text" id="start_time" name="start_time" class="form-control booking_dates" required readonly='true'>
                </div>
                <div class="field last">
				 <span class="field-txt">Number of passenger's</span>
                    <input placeholder="No of passenger's" value="" autocomplete="off" value="" type="text" id="capacity" name="capacity" class="form-control last" required>
                    <span class="form-select" id="capacityerror" style="color: red;font-size: 12px;"></span>
                </div>
				</div>
                <a href="{{ url('search') }}"><button type="submit" id="searchform" class="btn search btn-primary" name="send">Search</button></a>
            </form>
            <div id="startSpinner" style="display: none;position:absolute;left:19%;padding:2px;text-align: center;top:11px">
                <i class="fa fa-spinner"></i>
            </div>
            <div id="startSpinnerEnd" style="display: none;position:absolute;left:41%;padding:2px;text-align: center;top:11px">
                <i class="fa fa-spinner"></i>
            </div>
            <div class="form-select" id="locationsearch"></div>
        </div>
    </div>
</div>
<section class="dashboard view-more-bdy mb-5">

    <div class="container search-page">
        <div class="row">
		<div id="overclose" class="filter-close" onclick="closeNav()"></div>
           <div id="filter" class="col-left sidebar overlay">
                <h1>Sort and Filter</h1>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="overlay-content">
                    <h2 class="title">Filters</h2>
                    <form name="Myfomrs" id="Myfomrs" method="get">
                    <div class="field required last">
                        <label class="label"><span>Car Type</span><span class="requard">*</span></label>
                        <div class="content">
                            @if(isset($vehicleType))
                            @foreach($vehicleType as $type)
                           <div id="load" class="form-check" onclick="closeNav()">
                              <input class="form-check-input chkbox" type="checkbox" value="{{$type->id}}"  name="carType[]" id="car{{$type->id}}" data-name="{{ $type->vehicle_name }}">
                              <label class="form-check-label" for="{{ $type->vehicle_name }}">
                                {{ $type->vehicle_name }}
                              </label>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <div class="field required last">
                        <label class="label"><span>Price Range</span><span class="requard">*</span></label>
                        <div class="content">
                            @if(isset($maxPrice) && isset($minPrice) && $minPrice > 0)
                            @foreach (range($minPrice, $maxPrice,$times) as $key => $number) 
                            <?php  $value =  $number.'-'.($number+$times-1) ; ?>
                           <div id="load" class="form-check" onclick="closeNav()">
                              <input class="form-check-input chkbox" type="checkbox" value="{{ $value }}"  data-name="{{ $value }}" data-range="{{ $value }}" id="price{{$key+1}}" name="priceRange[]" data-min="{{ $number }}" data-max="{{ $number+$times-1 }}">
                              <label class="form-check-label" for="price{{$key+1}}">
                            {{ $value }}
                              </label>
                            </div>
                             @endforeach
                            @endif
                        </div>
                    </div>
                </form>
                 <form name="form2" id="form2">
                  <input type="hidden" name="carTypes" id="carTypes">
                  <input type="hidden" name="minRange" id="minRange">
                  <input type="hidden" name="maxRange" id="maxRange">
                  <input type="hidden" name="priceRanges" id="priceRanges">


                </form>
                </div>
            </div>
			<div class="nav-btm"><span class="filter" onclick="openNav()">SORT / FILTER</span></div>

            <div class="col-right">
               <div class="set-filters-wrapper f-12">
                <ul class="clearfix d-block filterdata">
                    
                        </ul>
                    </div>
         <h1 class="title">Available Rides in your Location</h1>
                <div class="section-3 section position-relative ">
                    <div class="container position-relative">

                        <div id="mySearchList"></div>
                        <div id="oldData">
                            <div class="row text-center new-append">
                                @if (count($booking)>0)
                                    @foreach ($booking as $list)
                                        <div class="col-12 even">
                                            <ul>
                                                <li class="place-sec even">
                                                    <span class="place even">
                                                        <span>{{ $list->startLocation }}</span>
                                                        <span class="icon-arrow"><i class="fa fa-long-arrow-right"
                                                                aria-hidden="true"></i></span>
                                                        <span>{{ $list->endLocation }}</span> </span>
                                                <li class="grey price-sec"><span class="price">{{$list->distance_price}}</span></li>
                                                </li>
                                                <?php $vehicleName = App\Models\VehicleType::getVehicleName($list->vehicle_id); ?>
                                                <li class="even frst car-name-sec"><span>{{$vehicleName}}</span>
                                                </li>
                                                <li class="grey car-no-sec"><span class="car-no">
                                                    <span>Departure Date & Time</span>
                                                    <span class="icon-arrow">
                                                        <i class="fa fa-long-arrow-right"     aria-hidden="true"></i></span>
                                                    <span>{{ $list->dateFormat($list->end_time) }}</span> </span></span>
                                                </li>
                                                @if($list->bookingRequestStatus == "0" && $list->payment_status == "1" )
                                                    <li class="even book-now-sec"><a href="javascript:void(0)" class="booknow" onClick="return alert('This car already book, please try with another car')" >book now</a>
                                                    <a class="quick-view" data-toggle="modal" data-target="#quickView-{{ $list->id }}">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>				
    												</li>
                                                    @else
                                                    <li class="even book-now-sec"><a href="#" class="booknow" data-toggle="modal" data-target="#myModal-{{$list->id}}" onClick="captcha('{{$list->id}}')">book now</a>
    												<a class="quick-view" data-toggle="modal" data-target="#quickView-{{ $list->id }}">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>	
    												</li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center error-massage">No record found</p>
                                @endif
                                {{$booking->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
	
	<!--<div id="filter" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
  </div>
</div>
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>-->


</section>
@foreach ($booking as $list)
<div class="modal my-modal-1 fade" id="quickView-{{ $list->id }}" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-inner d-flex">
                        <div class="col-sm-2 col-md-2 img-sec">
                            <span class="user-image"><img src="{{ asset('front/images/car-img-red.jpg') }}"
                                    alt="" /></span>
                        </div>
                        <div class="col-sm-8 col-md-8 details-sec">
                            <div class="details">
                                <?php $vehicleName = App\Models\VehicleType::getVehicleName($list->vehicle_type_id); ?>
                                <h2 class="name">{{ $vehicleName }}</h2>
                                <ul class="car-info d-flex">
                                    <li><strong>Rate/km :</strong><span>{{ $list->rate_per_km }}</span></li>
                                    <li><strong>Seating Capacity :</strong><span>{{ $list->capacity }}</span></li>
                                </ul>
                                <div class="driver-details">
                                    <p><strong>Driver Name :</strong><span>{{ $list->driverName }}</span></p>
                                    <p><strong>Driver Age :</strong><span>{{ $list->driverAge }}</span></p>
                                    <p><strong>Driver Mobile Number :</strong><span>{{ Str::limit($list->driverMobile, 6, $end='XXXX') }}</span></p>
                                    <p><strong>Driver License Number :</strong><span> {{ Str::limit( $list->driverLicenceNumber, 7, $end='XXXXX') }}</span>
                                    </p>
                                    <p><strong>Vehicle Registration Number :</strong><span> {{ Str::limit( $list->vehicleNumber, 7, $end='XXXXX') }}</span></p>
                                    <p><strong>Available Location :</strong><span>{{ $list->startLocation }}</span></p>
                                    <p><strong>Destination :</strong><span>{{ $list->endLocation }}</span></p>
                                    <p class="destination"><strong>Departure Date & Time</strong><span
                                            class="place">
                                            
                                            <span>{{ $list->dateFormat($list->end_time) }}</span> </span></p>

                                     <p class="tolls"><strong>Note :</strong> Customer has to pay one way tolls ( If any tolls exist in your route )</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 price-sec d-flex align-items-center">
                            <div class="price-btnsec">
                                <span class="price mb-3">{{ $list->distance_price }}</span>
                                @if($list->bookingRequestStatus == "0" && $list->payment_status == "1" )
                                    <a href="javascript:void(0)" class="booknow"
                                        onClick="return alert('This car already booked by other Customer, please try with another car')">book
                                        now</a>
                                @else
                                    <a href="javascript:void(0)" class="booknow" data-toggle="modal"
                                        data-target="#myModal-{{ $list->id }}"
                                        onClick="captcha('{{ $list->id }}')">book now</a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@foreach ($booking as $list)
<div class="modal book-modal" id="myModal-{{$list->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"
                        aria-hidden="true"></i></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 w-100">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-mobile-tab-{{$list->id}}" data-toggle="tab" href="#nav-mobile-{{$list->id}}" role="tab" aria-controls="nav-mobile"
                                        aria-selected="true">Mobile Verification</a>
                                    <a class="nav-item nav-link" id="nav-home-tab-{{$list->id}}"  href="#nav-home-{{$list->id}}" role="tab" aria-controls="nav-home"
                                        aria-selected="false">Customer Details</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab-{{$list->id}}"  href="#nav-profile-{{$list->id}}" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">Payment</a>
                                </div>
                                <div class="tab-pane fade show active" id="nav-mobile-{{$list->id}}" role="tabpanel" aria-labelledby="nav-mobile-tab">
                                    <div class="booking-form">
                                    
                                        <div class="step1-{{$list->id}}">
                                            <div class="alert alert-success d-none" id="sentSuccess-{{$list->id}}"></div>
                                            <div class="alert alert-danger d-none" id="error-{{$list->id}}"></div>
                                            <input type="hidden" id="bookingId" value="{{$list->id}}">
                                            <label for="">Enter Your Mobile Number</label>
                                            <input placeholder="Enter Your Mobile Number" type="text" class="form-control" id="mobileNo-{{$list->id}}"  onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" maxlength="10" >
                                            <div id="recaptcha-container-{{$list->id}}"></div>
                                            <span id="mobileNoError-{{$list->id}}" class="text-danger d-none">Please enter your nobile number</span><br>
                                            <span id="mobileNoLengthError-{{$list->id}}" class="text-danger d-none">Please enter your mobile number !!</span><br>

                                            <button name="send" onClick="verifyMobileNumber('{{$list->id}}')" class="btn search btn-primary" >Send OTP</button>
                                        </div>
                                        <div class="step2-{{$list->id}}" id="verifyOTP" style="display:none;">
                                            <div class="alert alert-success d-none" id="sentSuccessOTP-{{$list->id}}"></div>
                                            <div class="alert alert-danger d-none" id="errorOTP-{{$list->id}}"></div>
                                            <label for="">Enter OTP</label>
                                            <input placeholder="Enter Your OTP" type="text" class="form-control" id="OTP-{{$list->id}}"  onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                            <span id="otpError-{{$list->id}}" class="text-danger d-none">Please Enter OTP !!</span><br>
                                            <span id="otpMessage-{{$list->id}}" class="text-danger"></span><br>
                                            <button name="send" onclick="verifyOTP('{{$list->id}}')" class="btn search btn-primary" >Verify OTP</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-home-{{$list->id}}" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="booking-form">
                                    <div class="step1-booking-{{$list->id}}">
                                        <div class="alert alert-success d-none" id="sentSuccessOTPVerified-{{$list->id}}"></div>
                                        <form name="customerForm">
                                            <input type="text" class="form-control" id="name-{{$list->id}}" name="name" placeholder="Name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                                                <span id="nameError-{{$list->id}}" class="text-danger d-none">Please enter your full name</span>
                                                <input type="text" class="form-control" id="email-{{$list->id}}" name="email" placeholder="Email (Optional)" onkeyup="primaryEmail('{{$list->id}}',this.value)">
                                                <span style="color: red;" id="primaryEmailError-{{$list->id}}"></span>
                                                <input type="text" class="form-control last" id="location-{{$list->id}}" placeholder="Enter Your Address" name="address">
                                                <span id="locationError-{{$list->id}}" class="text-danger d-none">Please enter your full address </span>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckChecked-{{$list->id}}" required>
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                    Accept <a href="https://www.liftdedoo.com/terms-conditions" target="_blank">Terms and Conditions</a>
                                                    </label>
                                                </div>
                                                <span id="flexCheckCheckedError-{{$list->id}}" class="text-danger d-none">You have to accept terms and conditions</span>


                                            </form>
                                            <button name="send" class="btn search btn-primary" id="sendCustomerData-{{$list->id}}" onclick="addCustomerData('{{$list->id}}')" type="submit">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile-{{$list->id}}" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="booking-form payment">
                                        <form action="{{route('addPayment')}}" method="POST">
                                        <div class="step1-payment">
                                            @csrf
                                            <input type="hidden" name="mobile_no" id="payment_mobile_no">
                                            <input type="hidden" name="name" id="payment_name">
                                            <input type="hidden" name="email" id="payment_email">
                                            <input type="hidden" name="location" id="payment_location">
                                            <input type="hidden" name="bookingId" id="payment_bookingId">

                                            <div class="alert alert-success d-none" id="sentSuccessPayment-{{$list->id}}"></div>
                                            <h3>Payment</h3>
                                            <p class="totl-fr">Total Fare :</p> <span class="price mb-3">{{ $list->distance_price }}</span>

                                            <form>
                                                @if($list->travelAgentId == "")
                                                <div class="form-check d-inline-block">
                                                    
                                                    <p class="adv-pay">Please make 15% advance payment to confirm your booking, rest of the amount to be paid to the cab driver, once you reach the destination</p>
													<div class="radio-sec d-flex"><input class="form-check-input payment" type="radio" name="flexRadioDefault" id="flexRadioDefault1"  value="0">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        15% advance payment
                                                    </label>
													</div>
                                                </div>
                                                @endif
                                                @if($list->travelAgentId != "")
                                                <div class="form-check d-inline-block">
                                                    
                                                    <p class="adv-pay">Please make 5% advance payment to confirm your booking, rest of the amount to be paid to the cab driver, once you reach the destination</p>
													<div class="radio-sec d-flex"><input class="form-check-input payment" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="1">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        5% advance payment
                                                    </label>
													</div>
                                                </div>
                                                @endif
                                            </form>
                                            <span id="radioCheckedMsg-{{$list->id}}" class="text-danger d-none">please Select Payment</span>
                                            <button name="payment_btn" onclick="return validatePaymentRadio('{{$list->id}}');"  id="payment_btn" class="btn search btn-primary mt-3" type="submit">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal footer -->
</div>
<div id="loading" class='loader_new33' >
  <div id="loading-image"></div>
</div>
@endforeach
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>

  var firebaseConfig = {
  apiKey: "AIzaSyDSn9pjng5Zb7ihIQNyh86l0p7ewbQJvdM",
  authDomain: "liftdedoo-692e1.firebaseapp.com",
  projectId: "liftdedoo-692e1",
  storageBucket: "liftdedoo-692e1.appspot.com",
  messagingSenderId: "621188197237",
  appId: "1:621188197237:web:4a8195a1fc47c714fbc13c",
  measurementId: "G-TF5X1WLYM0"
};
firebase.initializeApp(firebaseConfig);
</script>

<script type="text/javascript">

    function captcha(bookingId)
    {
        $('#quickView-'+bookingId).modal('hide');
        render(bookingId);
    }
  
    function render(id) {    
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container-'+id);
        recaptchaVerifier.render();
    }
     /*-----------Start leftbar search------------------*/
    $("form[name=Myfomrs]").on("click", "input[name='carType[]']", function() {
        var values = $.map($("input[name='carType[]']:checked"), function(el) {
            return el.value;
        });

       var carTypes= $("form[name=form2]").find("input[name=carTypes]").val(values); 
       MyserchFilter();
      
    });
    $("form[name=Myfomrs]").on("click", "input[name='priceRange[]']", function() {
        var values = $.map($("input[name='priceRange[]']:checked"), function(el) {
            return el.value;
        });
        var min = $("input[name='priceRange[]']:checked").map(function () {
            return $(this).data('min')
        }).get();
       var max = $("input[name='priceRange[]']:checked").map(function () {
            return $(this).data('max')
        }).get();
        
       var priceRanges= $("form[name=form2]").find("input[name=priceRanges]").val(values); 
       var minRange= $("form[name=form2]").find("input[name=minRange]").val(min); 
       var maxRange= $("form[name=form2]").find("input[name=maxRange]").val(max); 
       MyserchFilter();
      
    });
    function MyserchFilter(){
        $('#loading').show();
        var carTypes = $("#carTypes").val();
        var priceRanges = $("#priceRanges").val();
        var minRange = $("#minRange").val();
        var maxRange = $("#maxRange").val();
        var url = "{{ url('getViewMoreLeftSearch') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                carTypes: carTypes,
                priceRanges: priceRanges,
                minRange: minRange,
                maxRange: maxRange,
            },
            success: function(data) {
                if(data) {
                    $('#loading').hide();
                    $('#oldData').hide();
                   
                    $('#mySearchList').html(data);
                } else {
                     $('#loading').hide();
                     $('#mySearchList').hide();
                     $('#oldData').show();
                     
                }
            },
        });
    }
/*    $(".chkbox").change(function() {
    // If checked
        var value = $(this).data('name');

        $list = $(".filterdata");
    if (this.checked) {
        //add to the right
        $list.append("<li class='fl set-filters '  data-value='" + value + "'>" + value + "<span class='close set-filter-close closebutton'>&times;</span> </li>");
        
    }
    else {
        //hide to the right
        $list.find('li[data-value="' + value + '"]').slideUp("fast", function() {
            $(this).remove();
        });
        
    }
});*/

    $(document).ready(function () {
    var $list = $(".filterdata");

    $(".chkbox").change(function () {
        var a = $(this).next().text();
        if (this.checked) {
            $('<li  class="fl set-filters"><a href="#" style="color:black">' + a + '</a><a class="closebutton" value="' + a + '"> <span class="close set-filter-close">&times;</span></a></li>').appendTo($list).data('src', this);

        } else {
            $(".filterdata li:contains('" + a + "')").remove();
        }
    })
    $(document).on('click', '.closebutton', function () {
        var $li = $(this).closest('li');
        $($li.data('src')).prop('checked', false);
        $li.remove();

        var values = $.map($("input[name='carType[]']:checked"), function(el) {
            return el.value;
        });

       var carTypes= $("form[name=form2]").find("input[name=carTypes]").val(values);

        var values = $.map($("input[name='priceRange[]']:checked"), function(el) {
            return el.value;
        });
        var min = $("input[name='priceRange[]']:checked").map(function () {
            return $(this).data('min')
        }).get();
       var max = $("input[name='priceRange[]']:checked").map(function () {
            return $(this).data('max')
        }).get();
        
       var priceRanges= $("form[name=form2]").find("input[name=priceRanges]").val(values); 
       var minRange= $("form[name=form2]").find("input[name=minRange]").val(min); 
       var maxRange= $("form[name=form2]").find("input[name=maxRange]").val(max); 
       MyserchFilter();
    });
});


    function primaryEmail(id,primaryemail) {
        var email = primaryemail;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {
            $("#sendCustomerData-"+id).attr("disabled", true);
            $("#primaryEmailError-"+id).text('Please enter valid email');
        }
        else
        {
            $("#sendCustomerData-"+id).attr("disabled", false);
            $("#primaryEmailError-"+id).text('');
        }
    }
    function verifyMobileNumber(bookingId) {
       
        var mobileNumber = "+91"+$("#mobileNo-"+bookingId).val();
        if(mobileNumber == ""){
            $("#mobileNoError-"+bookingId).removeClass("d-none");
        }
        else if(mobileNumber.length < 13)
        {
            $("#mobileNoError-"+bookingId).addClass("d-none");
            $("#mobileNoLengthError-"+bookingId).removeClass("d-none");
        }
        else{
            $("#mobileNoError-"+bookingId).addClass("d-none");
            $("#mobileNoLengthError-"+bookingId).addClass("d-none");
            var number = mobileNumber;
            firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
              
                    
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;
                console.log(coderesult);
        
                $("#sentSuccess-"+bookingId).text("Message Sent Successfully.");
                $("#sentSuccess"+bookingId).removeClass("d-none");
                $.ajax({
                    url : "{{route('checkUserMobile')}}",
                    data : {
                        mobile_no : mobileNumber,
                        _token: '{{ csrf_token() }}',
                    },
                    type : "POST",
                    success: function(data) {
                        $(".step2-"+bookingId).show();
                        $(".step1-"+bookingId).hide();
                        $("#sentSuccessOTP-"+bookingId).html("OTP Sent Successfully. Please Verify Your Mobile Number");
                        $("#sentSuccessOTP-"+bookingId).removeClass("d-none");
                    }
                })
            }).catch(function (error) {
                $("#error-"+bookingId).text(error.message);
                $("#error-"+bookingId).removeClass("d-none");
            });

            
        }
    }
    function addCustomerData(bookingId) {
        var mobileNumber = $("#mobileNo-"+bookingId).val();
        var name = $("#name-"+bookingId).val();
        var email = $("#email-"+bookingId).val();
        var location = $("#location-"+bookingId).val();
        var checkBox = document.getElementById("flexCheckChecked-"+bookingId);
        $("input[name=mobile_no]").val(mobileNumber);
        $("input[name=name]").val(name);
        $("input[name=email]").val(email);
        $("input[name=location]").val(location);
        $("input[name=bookingId]").val(bookingId);
        if(name.length == "" && location.length == "" && !$('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#nameError-"+bookingId).removeClass("d-none");
            $("#locationError-"+bookingId).removeClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).removeClass("d-none");
        }
        else if(name.length != "" && location.length == "" && !$('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#nameError-"+bookingId).addClass("d-none");
            $("#locationError-"+bookingId).removeClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).removeClass("d-none");
        }
        else if(location.length != "" && name.length == "" && !$('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#locationError-"+bookingId).removeClass("d-none");
            $("#nameError-"+bookingId).addClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).removeClass("d-none");
        }
        else if(location.length == "" && name.length == "" &&  $('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#locationError-"+bookingId).removeClass("d-none");
            $("#nameError-"+bookingId).removeClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).addClass("d-none");
        }
        else if(location.length != "" && name.length != "" &&  !$('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#locationError-"+bookingId).addClass("d-none");
            $("#nameError-"+bookingId).addClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).removeClass("d-none");
        }
        else if(location.length == "" && name.length != "" &&  $('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#locationError-"+bookingId).removeClass("d-none");
            $("#nameError-"+bookingId).addClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).addClass("d-none");
        }
        else if(location.length != "" && name.length == "" &&  $('#flexCheckChecked-'+bookingId).is(':checked'))
        {
            $("#locationError-"+bookingId).addClass("d-none");
            $("#nameError-"+bookingId).removeClass("d-none");
            $('#flexCheckCheckedError-'+bookingId).addClass("d-none");
        }

        else
        {
            $.ajax({
            url : "{{route('addCustomerData')}}",
                data : {
                    mobile_no : mobileNumber,
                    name:name,
                    email:email,
                    location:location,
                    _token: '{{ csrf_token() }}',
                },
                type : "POST",
                success: function(data) {
                    $('#nav-home-'+bookingId).removeClass('active');
                    $('#nav-home-'+bookingId).removeClass('show');
                    $('#nav-home-tab-'+bookingId).removeClass('active');
                    $('#nav-home-tab-'+bookingId).removeAttr('data-toggle');
                    $('#nav-profile-'+bookingId).addClass('active');
                    $('#nav-profile-'+bookingId).addClass('show');
                    $('#nav-profile-tab-'+bookingId).attr('data-toggle','tab');
                    $('#nav-profile-tab-'+bookingId).addClass('active');
                    
                }
            });
        }
    }
    function addPayment(bookingId) {
        var radiobutton = $("input[name='flexRadioDefault']:checked");
        if (radiobutton.length == 0) {
            $('#radioCheckedMsg-'+bookingId).removeClass("d-none");
        }
        else
        { 
            $('#radioCheckedMsg-'+bookingId).addClass("d-none");
            $("#addPayment-"+bookingId).attr("disabled", true);
            var mobileNumber = $("#mobileNo-"+bookingId).val();
            var name = $("#name-"+bookingId).val();
            var email = $("#email-"+bookingId).val();
            var location = $("#location-"+bookingId).val();
            var paymentType = $('input[type="radio"][name="flexRadioDefault"]:checked').val();
            var bookingId =bookingId;
            $.ajax({
            url : "{{route('addPayment')}}",
                data : {
                    mobile_no : mobileNumber,
                    name:name,
                    email:email,
                    location:location,
                    paymentType: paymentType,
                    bookingId: bookingId,
                    _token: '{{ csrf_token() }}',
                },
                type : "POST",
                success: function(data) {
                    console.log($('#myModal-'+bookingId).val());
                    $("#sentSuccessPayment-"+bookingId).html("Your booking is confirmed, Customer service representative will contact you shortly!");
                    $("#sentSuccessPayment-"+bookingId).removeClass("d-none");
                    // window.setTimeout(
                    //     function(){
                    //         window.document.location.reload(true);
                    //     },3000);
                }
            })
        }
    }
    function verifyOTP(bookingId) {
             
        var otpNumber = $("#OTP-"+bookingId).val();
        var mobileNumber = $("#mobileNo-"+bookingId).val();
        if(otpNumber == ""){
            $("#otpError-"+bookingId).removeClass("d-none");
        }else{
            var code = $("#OTP-"+bookingId).val();
            coderesult.confirm(code).then(function (result) {
                var user=result.user;
                $.ajax({
                    url : "{{route('verifyOtp')}}",
                    data : {
                        otp_no : otpNumber,
                        mobile_no: mobileNumber,
                        _token: '{{ csrf_token() }}',
                    },
                    type : "POST",
                    success: function(data) {
                        if(data == "verified") {
                            $('#nav-mobile-'+bookingId).removeClass('active');
                            $('#nav-mobile-'+bookingId).removeClass('show');
                            $('#nav-mobile-tab-'+bookingId).removeClass('active');
                            $('#nav-home-'+bookingId).addClass('active');
                            $('#nav-home-'+bookingId).addClass('show');
                            $('#nav-home-tab-'+bookingId).addClass('active');
                            $('#nav-mobile-tab-'+bookingId).removeAttr('data-toggle');
                            $('#nav-home-tab-'+bookingId).attr('data-toggle','tab');
                            $("#sentSuccessOTPVerified-"+bookingId).html("Congratulation you have successfully verified your mobile number.");
                            $("#sentSuccessOTPVerified-"+bookingId).removeClass("d-none");
                        }else{
                            $('#otpMessage-'+bookingId).html(data);
                        }
                    }
                })
            }).catch(function (error) {
                $("#errorOTP-"+bookingId).text(error.message);
                $("#sentSuccessOTP-"+bookingId).addClass("d-none");
                $("#errorOTP-"+bookingId).removeClass('d-none');
            });      
        }
    }
</script>
<script>
    $(document).ready(function() {
        var date = new Date();
        var addDays = date.setDate(date.getDate() + 6);
        $('.booking_dates').datetimepicker({
            startDate: new Date(),
            format:'dd-mm-yyyy hh:ii',
            endDate: new Date(addDays),
            autoclose: true,
        });
    });

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
                            $("#locationsearch").text("No location found");
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
    function validatePaymentRadio(bookingId)
    {
        var radios = document.getElementsByName("flexRadioDefault");
        var formValid = false;
        var i = 0;
        while (!formValid && i < radios.length) {
            if (radios[i].checked) formValid = true;
            i++;        
        }
        if (!formValid) 
        {
            $('#radioCheckedMsg-'+bookingId).removeClass("d-none");
            return false;
        }
        else
        {
            return formValid;
        }
    }
</script>
<script>
function openNav() {
  document.getElementById("filter").style.display = "block";
  document.getElementById("overclose").style.display = "block";
}

function closeNav() {
  document.getElementById("filter").style.display = "none";
  document.getElementById("overclose").style.display = "none";
  document.getElementById("load").style.display = "none";
}
</script>
<script>

function openNav2() {
  document.getElementById("searchmodal").style.display = "block";
  document.getElementById("search-modl").style.display = "none";

}

function closeNav2() {
  document.getElementById("searchmodal").style.display = "none";
  document.getElementById("search-modl").style.display = "block";

}
</script>
@include('front.include.footer')
