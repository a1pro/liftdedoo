@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="dashboard my-account mb-5">

    <div class="container driver-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
                @if (session()->has('status'))
                    <div class="alert alert-success message">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('status') }}
                    </div>
                @elseif(session()->has('update'))
                    <div class="alert alert-success message">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('update') }}
                    </div>
                @elseif (session()->has('change'))
                    <div class="alert alert-success message">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('change') }}
                    </div>
                @endif
                <h1 class="title">Welcome <span class="name">{{ $agent->agency_name }}</span></h1>
                @if($auth->mobile_verify_status=="0")
                    <a href="#" class="booknow" data-toggle="modal" onClick="captcha('{{$auth->id}}')" data-target="#myModal-{{$auth->id}}">Verify Mobile</a>
                @endif
				
				
				<div class="box dash-sec">
                    <div class="box-content">
						<div class="row">
						  <div class="col-6 col-md-3 box-add frst">
						   <div class="add-sec">
						    <a href="{{ url('agency-car-info') }}">
							  <span class="img-sec"><img src="{{ asset('front/images/vehicle.png') }}" alt="" /></span>
							  <span class="addlink"><span>+</span> Add Vehicle</span>
							 </a>
							</div>
						  </div>
						  <div class="col-6 col-md-3 box-add scnd">
						  <div class="add-sec">
						  <a href="{{ url('agency-driver-info') }}">
						  <span class="img-sec"><img src="{{ asset('front/images/driver-info.png') }}" alt="" /></span>
						  <span class="addlink"><span>+</span> Add Driver</span>
						  </a>
						  </div>
						  </div>
						  <div class="col-6 col-md-3 box-add thrd">
						  <div class="add-sec">
						  <a href="{{ url('travel-agency-availability-booking') }}">
						  <span class="img-sec"><img src="{{ asset('front/images/avibility.png') }}" alt="" /></span>
						  <span class="addlink">Book Availability</span>
						  </a>
						  </div>
						  </div>
						  <div class="col-6 col-md-3 box-add frth">
						  <div class="add-sec">
						  <a href="{{ url('travel-agency-booking-history') }}">
						  <span class="img-sec"><img src="{{ asset('front/images/book-history.png') }}" alt="" /></span>
						  <span class="addlink">Booking History</span>
						  </a>
						  </div>
						  </div>
						</div>
					</div>
				</div>

              <div id="accordion" class="box">
			  <a class="card-link collapsed" data-toggle="collapse" href="#collapseNine">My Info</a>
                    <div id="collapseNine" class="box-content collapse" data-parent="#accordion">
                        <ul>
                            <li>Travel Agency Name : <strong>{{ $agent->agency_name }}</strong></li>
                            <li>Agency Trade Licence Number : <strong class="uppercase">{{ $agent->registration_number }}</strong>
                            </li>
                            <li>Number Of Vehicles : <strong>{{ $agent->number_of_vehicles }}</strong></li>
                            <li>Mobile Number : <strong>{{ $auth->mobile }}</strong>
                                @if($auth->mobile_verify_status=="1")
                                    <a href="#" class="tooltp" data-toggle="tooltip" data-placement="bottom" title="Your Mobile Number is Verified"><i style="color: green;" class="bx bxs-badge-check"></i></a>
                                @endif
                            </li>
                            @if ($auth->email != null)
                                <li>Email : <strong>{{ $auth->email }}</strong></li>
                            @else
                                <li>Email : <strong>---</strong></li>
                            @endif
                        </ul>
                        <input type="hidden" id="agencyNumber" value="{{$auth->mobile }}">
                        <a class="edit" href="{{ route('EditTravelProfile') }}">edit</a>
                    </div>
                </div>
				
            </div>
        </div>

    </div>
    </div>
    <div class="modal book-modal" id="myModal-{{$auth->id}}">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"
                            aria-hidden="true" ></i></button>
                </div>
            <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 w-100">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-mobile-tab-{{$auth->id}}" data-toggle="tab" href="#nav-mobile-{{$auth->id}}" role="tab" aria-controls="nav-mobile"
                                            aria-selected="true">Mobile Verification</a>
                                    </div>
                                    <div class="tab-pane fade show active" id="nav-mobile-{{$auth->id}}" role="tabpanel" aria-labelledby="nav-mobile-tab">
                                        <div class="booking-form">
                                            <div class="step1-{{$auth->id}}">
                                                <div class="alert alert-success d-none" id="sentSuccess-{{$auth->id}}"></div>
                                                <div class="alert alert-danger d-none" id="error-{{$auth->id}}"></div>
                                                <input type="hidden" id="bookingId" value="{{$auth->id}}">
                                                <label for="">Verify Your Mobile Number</label>
                                                <input placeholder="Enter Your Mobile Number" type="text" class="form-control" id="mobileNo-{{$auth->id}}" value="{{ $auth->mobile}}" readonly="">
                                                <div id="recaptcha-container-{{$auth->id}}"></div>
                                                <button name="send" onClick="verifyMobileNumber('{{$auth->id}}')" class="btn search btn-primary">Send OTP</button>
                                            </div>
                                            <div class="step2-{{$auth->id}}" id="verifyOTP" style="display:none;">
                                                <div class="alert alert-success d-none" id="sentSuccessOTP-{{$auth->id}}"></div>
                                                <div class="alert alert-danger d-none" id="errorOTP-{{$auth->id}}"></div>
                                                <label for="">Enter OTP</label>
                                                <input placeholder="Enter Your OTP" type="text" class="form-control" id="OTP-{{$auth->id}}"  onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                                <span id="otpError-{{$auth->id}}" class="text-danger d-none">Please Enter OTP !!</span><br>
                                                <span id="otpMessage-{{$auth->id}}" class="text-danger"></span><br>
                                                <button name="send" onclick="verifyOTP('{{$auth->id}}')" class="btn search btn-primary" >Verify OTP</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
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
        render(bookingId);
    }

    function render(id) {
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container-'+id);
        recaptchaVerifier.render();
    }

    function verifyMobileNumber(bookingId) {
        var mobileNumber = $("#agencyNumber").val();
        var number = "+91"+$("#agencyNumber").val();
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
                    $("#sentSuccessOTP-"+bookingId).html("OTP sent successfully. Please verify your mobile number");
                    $("#sentSuccessOTP-"+bookingId).removeClass("d-none");
                }
            })
        }).catch(function (error) {
            $("#error-"+bookingId).text(error.message);
            $("#error-"+bookingId).removeClass("d-none");
        });

    }
    
    function verifyOTP(bookingId) {
        var otpNumber = $("#OTP-"+bookingId).val();
        var mobileNumber = $("#agencyNumber").val();
        if(otpNumber == ""){
            $("#otpError-"+bookingId).removeClass("d-none");
        }else{
        var code = $("#OTP-"+bookingId).val();
        coderesult.confirm(code).then(function (result) {
                var user=result.user;
                $.ajax({
                    url : "{{route('verifyMobile')}}",
                    data : {
                        otp_no : otpNumber,
                        mobile_no: mobileNumber,
                        _token: '{{ csrf_token() }}',
                    },
                    type : "POST",
                    success: function(data) {
                        if(data == "success") {
                            $("#errorOTP-"+bookingId).addClass("d-none");
                            $("#sentSuccessOTP-"+bookingId).html("Congratulation! successfully you have verified your mobile number.");
                            $("#sentSuccessOTP-"+bookingId).removeClass("d-none");
                            window.setTimeout(
                            function(){
                                window.document.location.reload(true);
                            },3000);
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
    $(".alert.message").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
<script>
//$.noConflict();
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@include('front.include.footer')
