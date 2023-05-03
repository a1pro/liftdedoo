@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">
<div class="wrapper d-flex d-md-block">
<section class="section-1 ind-bg section banner-section relative">

    <div class="overlay"></div>
	<div class="container">
	  <div class="row text-center align-items-center d-md-flex d-block">
	  <div class="col-md-6 banner-content">
	   <h1 class="title wow fadeInLeft" data-wow-duration="0.5s">One way journey one way fare.</h1>
	   <p class="wow fadeInLeft" data-wow-duration="0.5s">
	   There are thousand of cars which are travelling each day between the cities. Among these most of the cars after dropping the customer to their destinations are returning back empty. Liftdedoo will be connecting those cars to the customers who wishes to take that one sided travel and will have to pay ony for that one sided journey.
<p class="mb-0 wow fadeInLeft" data-wow-duration="0.5s">'NO Double Payment For One Sided Trip'</p>
<p class="mb-0 wow fadeInLeft" data-wow-duration="0.5s">Liftdedoo brings the concept of " One Way Trip..One Way Payment"</p>
	   </p>
	  </div>
	  <div class="col-md-6">
	    <h1 class="title wow fadeInRight" data-wow-duration="1s">Search Rides</h1>
		<div id="date-picker-example" class="banner-search1 md-form md-outline input-with-post-icon datepicker wow fadeInRight" data-wow-duration="1s"
            inline="true">
            <form method="POST" id="searchForm" action="{{ url('search') }}">
                @csrf
               <div class="field d-flex">
			   <span class="input-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <input placeholder="Current location" autocomplete="off" type="text" id="start_location" name="start_location" class="form-control" required onChange="checkLocation(this.value)">
                <span class="form-select" id="locationsearch" style="color: red;font-size: 12px;"></span>
               </div>
			   <div class="field last d-flex">
			   <span class="input-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <input type="hidden" name="strtLocId" id="strtLocId">
                <input placeholder="Destination" autocomplete="off" type="text" id="end_location" name="end_location" class="form-control" required onChange="checkEndLocation(this.value)">
                    <span class="form-select" id="locationsearch2" style="color: red;font-size: 12px;"></span>
                </div>
				<div class="field d-flex">
				<span class="input-icon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                <input type="hidden" name="endLocId" id="endLocId">
                <input placeholder="Date of journey" type="text" id="start_time" name="start_time" class="form-control booking_dates" required autocomplete="off">
				</div>
				<div class="field last d-flex">
				<span class="input-icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <input placeholder="Mobile Number" autocomplete="off" value="" type="text" id="phone" name="phone" maxlength="10" pattern="\d{10}"  minlength="10"  onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" class="form-control last" required   oninvalid="setCustomValidity('Please enter 10 digit mobile number')"
                        onchange="try{setCustomValidity('')}catch(e){}"   >
                <span class="form-select" id="capacityerror" style="color: red;font-size: 12px;"></span>
                </div>
                <div class="actions"><a class="btn-srch" href="{{ url('search') }}"><button type="submit" id="searchform" class="btn search btn-primary"
                        name="send">Search</button></a></div>
            </form>
            <div id="startSpinner" style="display: none;position:absolute;right:33%;padding:2px;text-align: center;top:29px">
                <i class="fa fa-spinner"></i>
            </div>
            <div id="startSpinnerEnd" style="display: none;position:absolute;right:33%;padding:2px;text-align: center;top:90px">
                <i class="fa fa-spinner"></i>
            </div>
            <div class="form-select" id="locationsearch"></div>
        </div>
	  </div>
	</div>
	</div>
    <!--<div class="container relative text-center">

        @if (session()->has('message'))
        <div class="alert message alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session()->get('message') }}
        </div>
        @elseif (session()->has('error'))
        <div class="alert message alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session()->get('error') }}
        </div>
        @endif
        <h1 class="title wow fadeInDown" data-wow-duration="1s">Search available Rides</h1>
        <div id="date-picker-example" class="banner-search md-form md-outline input-with-post-icon datepicker wow fadeInUp" data-wow-duration="1s"
            inline="true">
            <form method="POST" id="searchForm" action="{{ url('search') }}">
                @csrf
               <div class="field">
                <input placeholder="Current location" autocomplete="off" type="text" id="start_location" name="start_location"
                    class="form-control" required onChange="checkLocation(this.value)">
                <span class="form-select" id="locationsearch" style="color: red;font-size: 12px;"></span>
               </div>
			   <div class="field last">
                <input type="hidden" name="strtLocId" id="strtLocId">
                <input placeholder="Destination" autocomplete="off" type="text" id="end_location" name="end_location"
                    class="form-control" required onChange="checkEndLocation(this.value)">
                    <span class="form-select" id="locationsearch2" style="color: red;font-size: 12px;"></span>
                </div>
				<div class="field">
                <input type="hidden" name="endLocId" id="endLocId">
                <input placeholder="Date of journey" type="text" id="start_time" name="start_time"
                    class="form-control booking_dates" required readonly='true'>
				</div>
				<div class="field last">
                <input placeholder="No of passenger's" autocomplete="off" value="" type="text" id="capacity" name="capacity" class="form-control last" required>
                <span class="form-select" id="capacityerror" style="color: red;font-size: 12px;"></span>
                 </div>
                <a href="{{ url('search') }}"><button type="submit" id="searchform" class="btn search btn-primary"
                        name="send">Search</button></a>
            </form>
            <div id="startSpinner" style="display: none;position:absolute;left:19%;padding:2px;text-align: center;top:11px">
                <i class="fa fa-spinner"></i>
            </div>
            <div id="startSpinnerEnd" style="display: none;position:absolute;left:41%;padding:2px;text-align: center;top:11px">
                <i class="fa fa-spinner"></i>
            </div>
            <div class="form-select" id="locationsearch"></div>
        </div>
    </div>-->
    <div class="btm-bg"></div>
	</section>

<section class="section-2 ind-sec section position-relative pt-5 pb-3">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-4 icon-txt wow fadeInLeft" data-wow-duration="0.5s">
                <span class="icon-title"><img src="{{ asset('front/images/low-price.png') }}" alt="" /></span>
                <h3>Pick your lift at low prices.</h3>
                <p>We guarantee you the lowest fare cab service in West Bengal. Forget up down cab fare. You only pay
                    what you see before booking, no other charges.</p>
            </div>
            <div class="col-md-4 icon-txt wow fadeInUp" data-wow-duration="0.5s">
                <span class="icon-title"><img src="{{ asset('front/images/trust.png') }}" alt="" /></span>
                <h3>Trust is the matter !</h3>
                <p>All drivers and car agencies are registered with us, which helps us to provide reliable, safe,
                    transparent, and trusted cabs for every occasion. </p>
            </div>
            <div class="col-md-4 icon-txt wow fadeInRight" data-wow-duration="0.5s">
                <span class="icon-title"><img src="{{ asset('front/images/car-updw.png') }}" alt="" /></span>
                <h3>One way journey one way fare.</h3>
                <p>Select any pick and drop location in West Bengal and save 50%. Taxi providers are ready for one-way
                    fare as they are getting another customer for a return. </p>
            </div>
        </div>
    </div>
</section>

<section class="section-4 section position-relative py-5">
  <div class="container">
    <div class="row">
	  <h1 class="title text-center wow fadeInLeft" data-wow-duration="0.5s">Why Lift Dedoo ?</h1>

<p class="wow fadeInUp" data-wow-duration="2s">There are thousand of cars which are travelling each day between the cities.Among these most of the cars after dropping the customer to their destinations are returning back empty. Liftdedoo will be connecting those cars to the customers who wishes to take that one sided travel and will have to pay ony for that one sided journey. <br>
'NO Double Payment For One Sided Trip'.<br> Liftdedoo brings the concept of " One Way Trip..One Way Payment".</p>
	</div>
  </div>
</section>
<section class="section-5 section position-relative pt-4 pb-5">
  <div class="container">
    <div class="row">
	<h1 class="title text-center wow fadeInUp" data-wow-duration="0.5s">Frequently Asked Questions</h1>
      <div class="accordion" id="accordionfaq">
	  <div class="row">
	   <div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen"> 
		Can i book in advance if there are no cab availability?                          
        </h2>
		<div id="collapseTen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Of course you can, Just click on book my enquiry and fill the details we will get back to you if there are any cars available as per your requirement</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapseeleven" aria-expanded="true" aria-controls="collapseeleven"> 
		   What’s the minimum amount i need to pay for booking?                      
        </h2>
		<div id="collapseeleven" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Min 5% to Max 15% depend on the drop location, and rest of the amount you need to pay in cash to the respective driver.</p>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsetwoelvw" aria-expanded="true" aria-controls="collapsetwoelvw"> 
		 Can i cancel any time? What’s the process?                        
        </h2>
		<div id="collapsetwoelvw" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Of course you can before the last minute of your departure once schedule departure time is over, we will treat as no show and no refund will be issue.</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsethirteen" aria-expanded="true" aria-controls="collapsethirteen"> 
		    Can I get service locally?                     
        </h2>
		<div id="collapsethirteen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>No we provide only intercity cab service, Min 40Km.</p>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsefourteen" aria-expanded="true" aria-controls="collapsefourteen"> 
		 Who is providing me the service?                         
        </h2>
		<div id="collapsefourteen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Mostly the cabs which are coming to Kolkata and while go back without passenger, they will drop you at your destination</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsesixteen" aria-expanded="true" aria-controls="collapsesixteen"> 
		  In case of any emergency will i get the details from the service provider?                       
        </h2>
		<div id="collapsesixteen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Absolutely as all the travel partners are register with valid documents. We are Just a call away from you.</p>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapseseventenn" aria-expanded="true" aria-controls="collapseseventenn"> 
		  Liftdedoo is available in pan India or only in west Bengal?                       
        </h2>
		<div id="collapseseventenn" class="box-content collapse" data-parent="#accordionfaq">
		 <p>No we are available only in west Bengal.</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapseeightteen" aria-expanded="true" aria-controls="collapseeightteen"> 
		   Do i have to pay toll tax?                      
        </h2>
		<div id="collapseeightteen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Yes you have to pay one-way toll tax, if applicable.</p>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsenineteen" aria-expanded="true" aria-controls="collapsenineteen"> 
		   Is there any hidden tax or charges do I need to pay?                      
        </h2>
		<div id="collapsenineteen" class="box-content collapse" data-parent="#accordionfaq">
		 <p>No not at all.</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsetwenty" aria-expanded="true" aria-controls="collapsetwenty"> 
		 Will i get charge anything extra if i ask for home drop from my drop location?                         
        </h2>
		<div id="collapsetwenty" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Within 10 KM no extra charges, after 10 you will charge as per travel agency Rate/km</p>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="faq col-md-6 wow fadeInLeft" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsetwentyone" aria-expanded="true" aria-controls="collapsetwentyone"> 
		     Can i share my trip with my family member and friends?                     
        </h2>
		<div id="collapsetwentyone" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Yes, you can travel along with the family member and friend with the cab capacity</p>
		</div>
		</div>
		<div class="faq col-md-6 wow fadeInRight" data-wow-duration="0.5s">
	    <h2 class="title collapsed" type="button" data-toggle="collapse" data-target="#collapsetwentytwo" aria-expanded="true" aria-controls="collapsetwentytwo"> 
		  What if the cab broke down? Will I get replacement?                   
        </h2>
		<div id="collapsetwentytwo" class="box-content collapse" data-parent="#accordionfaq">
		 <p>Depends on the availability and Distance, if we are unable to provide us the replacement we will refund. T&C apply</p>
		</div>
		</div>
	  </div>
	  </div>
	</div>
  </div>
</section>
</div>


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
                                    <p><strong>Driver Mobile Number :</strong><span>
                                    {{ Str::limit($list->driverMobile, 6, $end='XXXX') }}
                                   </span></p>
                                    <p><strong>Driver License Number :</strong><span>
                                    {{ Str::limit( $list->driverLicenceNumber, 7, $end='XXXXX') }}
                                    </span>
                                    </p>
                                    <p><strong>Vehicle Registration Number :</strong><span>
                                    {{ Str::limit( $list->vehicleNumber, 7, $end='XXXXX') }}</span></p>
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
                                        onClick="return alert('This car already book, please try with another car')">book
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
                                            <div id="recaptcha-container-{{$list->id}}" class="recaptcha-container-{{$list->id}}"></div>
                                            <span id="mobileNoError-{{$list->id}}" class="text-danger d-none">Please enter your mobile number</span><br>
                                            <span id="mobileNoLengthError-{{$list->id}}" class="text-danger d-none">Please enter valid mobile number</span><br>
                                            <span id="captchaError-{{$list->id}}" class="text-danger d-none">Please select captcha</span><br>

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
                                            <input type="text" class="form-control" id="name-{{$list->id}}" name="name" placeholder="Enter Full Name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                                                <span id="nameError-{{$list->id}}" class="text-danger d-none">Please enter your full name </span>
                                                <input type="text" class="form-control" id="email-{{$list->id}}" name="email" placeholder="Email (Optional)" onkeyup="primaryEmail('{{$list->id}}',this.value)">
                                                <span style="color: red;" id="primaryEmailError-{{$list->id}}"></span>
                                                <input type="text" class="form-control last" id="location-{{$list->id}}" placeholder="Enter Your Full Address" name="address">
                                                <span id="locationError-{{$list->id}}" class="text-danger d-none">Please enter your address </span>
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
@endforeach
</div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/wow.min.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/animated.js') }}" charset="UTF-8"></script>
</script>
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
        if(mobileNumber.length == 0){
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
                // $("#captchaError-"+bookingId).addClass("d-none");
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;
                console.log(coderesult);

                $("#sentSuccess-"+bookingId).text("Message sent successfully.");
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
                        $("#sentSuccessOTP-"+bookingId).html("OTP sent successfully. Please verify your mobile number");
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
        // pass values in payment form start
        $("input[name=mobile_no]").val(mobileNumber);
        $("input[name=name]").val(name);
        $("input[name=email]").val(email);
        $("input[name=location]").val(location);
        $("input[name=bookingId]").val(bookingId);

        // pass values in payment form over
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
                    window.setTimeout(
                        function(){
                            window.document.location.reload(true);
                        },3000);
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
                            $("#sentSuccessOTPVerified-"+bookingId).html("Congratulation you have sucessfully verified your mobile number.");
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

    $(document).ready(function() {
        $('.booking_dates').keydown(function (event) {
            event.preventDefault();
        });
        $("#verifyOTP").hide();
        var date = new Date();
        var addDays = date.setDate(date.getDate() + 6);
        $('.booking_dates').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: 0,
            maxDate: 6,
            startDate: new Date(),
            endDate: new Date(addDays)
        });
    });
    $(document).ready(function() {
        $("#start_location").autocomplete({
            source: function(request, response) {
                var url = "{{ route('searchcity') }}";
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
                            $("#searchform").attr("disabled", false);
                        } else {
                            $("#strtLocId").val('');
                            $("#locationsearch").text("No location found");
                            $("#searchform").attr("disabled", true);
                        }
                    }

                });
            },
            minLength: 1,
        });
    });

    $(document).ready(function() {
        $("#end_location").autocomplete({
            source: function(request, response) {
                var url = "{{ route('searchcity') }}";
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
                    beforeSend: function() {

                    },
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
                            $("#searchform").attr("disabled", false);
                        } else {
                            $("#endLocId").val('');
                            $("#locationsearch2").text("No location found");
                            $("#searchform").attr("disabled", true);
                        }
                    }
                });
            },
            minLength: 1
        });
        $('#capacity').on('keyup', function() {
            this.value = this.value.replace(/[^1-7]/gi, '');

            if(this.value)
            {
                $("#capacityerror").text('');
                $("#searchform").attr("disabled", false);
            }
            else{
                $("#capacityerror").text("Maximum 7 Passengers");
                $("#searchform").attr("disabled", true);
            }
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
                        $("#searchform").attr("disabled", true);
                    }
                    else
                    {
                        $("#searchform").attr("disabled", false);
                    }
                } else {
                    $("#locationsearch").text("No location found");
                    $("#searchform").attr("disabled", true);
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
                        $("#searchform").attr("disabled", true);
                    }
                    else
                    {
                        $("#searchform").attr("disabled", false);
                    }
                } else {
                    $("#locationsearch2").text("No location found");
                    $("#searchform").attr("disabled", true);
                }
            },
        });
    }
    $(".alert.message").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });

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
<script type="text/javascript">
 $(document).ready(function() {
     if (sessionStorage.getItem('#availaberideModal') !== 'true') {
         $('#availaberideModal').modal('show');
         sessionStorage.setItem('#availaberideModal','true');     
     }
 });
</script>
<!--<script type="text/javascript">
$(document).ready(function () {

    $('#availaberideModal').modal('show');

});

</script>-->
@include('front.include.footer')
