<footer class="page-footer pb-0">
    <div class="container">
        <div class="row pt-3 pb-0 d-flex ">
            <div class="accordion d-flex" id="accordionExample">
                <div class="card first col-md-4 align-items-center">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                            </button>
                        </h2>
                    </div>
                    <div class="collapse show wow fadeInUp" data-wow-duration="1s">
                        <div class="card-body">
                            <a class="footer-logo" href="{{ url('/') }}"><img
                                    src="{{ asset('front/images/ftr-logo.png') }}" alt="liftdedoo.com" /></a>
                            <p>Why pay for a return when you are traveling one way? Just search your destination and find your available lift with us. A big pool of taxi providers is waiting to serve you best at the lowest price. </p>
                        </div>
                    </div>
                </div>
                <div class="card col-auto align-items-center wow fadeInUp" data-wow-duration="1s">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                               Information
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><a class="{{ Request::segment(1) ==  'about-us' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'about-us' ? 'color:#f42e00' : ''  }} " href="{{ url('about-us') }}">About Us</a></li>
                                <li><a class="{{ Request::segment(1) ==  'contact-us' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'contact-us' ? 'color:#f42e00' : ''  }} " href="{{ url('contact-us') }}">Contact Us</a></li>
                                
                                <li> <a class="{{ Request::segment(1) ==  'mission-vission' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'mission-vission' ? 'color:#f42e00' : ''  }}" href="{{ url('mission-vission') }}">Mission &amp; Vission</a></li>
                                <li> <a class="{{ Request::segment(1) ==  'how-its-work' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'how-its-work' ? 'color:#f42e00' : ''  }} " href="{{ url('how-its-work') }}">How it's Work</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 align-items-center wow fadeInUp" data-wow-duration="1s">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Quick Links
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><a href="/driver-policy" style="{{ Request::segment(1) ==  'driver-policy' ? 'color:#f42e00' : ''  }} ">Driver Policy</a></li>
                                <li><a class="{{ Request::segment(1) ==  'terms-conditions' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'terms-conditions' ? 'color:#f42e00' : ''  }} " href="{{ url('terms-conditions') }}">Terms & Conditions</a></li>
                                <!-- <li><a class="{{ Request::segment(1) ==  'privacy-policy' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'privacy-policy' ? 'color:#f42e00' : ''  }} " href="{{ url('privacy-policy') }}">Privacy Policy</a></li> -->
                                <li><a class="{{ Request::segment(1) ==  'refund-policy' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'refund-policy' ? 'color:#f42e00' : ''  }} " href="{{ url('refund-policy') }}">Refund Policy</a></li>
                                <li class="cancel"><a class="{{ Request::segment(1) ==  'data-protection' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'cancel-booking' ? 'color:#f42e00' : ''  }} " href="{{ url('cancel-booking') }}">Cancel Booking</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 align-items-center wow fadeInUp" data-wow-duration="1s">
                    <div class="card-header" id="headingFive">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                data-toggle="collapse" data-target="#collapseFive" aria-expanded="false"
                                aria-controls="collapseFour">
                               Contact us
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                        data-parent="#accordionExample">
                        <div class="card-body footer-address">
                            <ul>
                                <li><i class="fa fa-map-marker" aria-hidden="true"></i><span>(Debomita apartment) 8/7
                                        Chinar park, Kol-700136</span></li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i><a
                                        href="tel:18008911324"><span>Toll Free Number : 1800-891-1324</span></a></li>
                            </ul>
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
	  <div class="row">
	   <div class="attach text-center d-flex wow fadeInUp" data-wow-duration="1s">
	     <div class="attach-inr">
		  <h2>Attach my Car:</h2>
		  <p>
		   <a href="{{ url('travel-agency-registration') }}" class="btn attach-btn btn-primary">Travel Agent</a>
		   <a href="{{ url('driver-registration') }}" class="btn attach-btn btn-primary">Individual Driver</a>
		  </p>
		 </div>
		</div>
	   </div>	
    </div>
    <div class="col-md-12 footer-btm col-auto text-center align-items-center">
        <div class="container p-0">
            <span class="copyright"><span>Copyright &copy; {{ date('Y') }} liftdedoo.com | All Rights
                    Reserved.</span></span>
            <div class="social">
                <a href="https://www.facebook.com/Lift-dedoocom-102465675540912/" target="_blank" class="d-inline-block">
                    <span class="sr-only">Facebook</span>
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="https://wa.me/message/XYXBQLHUOY2LA1" target="_blank" class="d-inline-block">
                    <span class="sr-only">whatsapp</span>
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </a>
                <a href="https://twitter.com/liftdedoo_com?t=UEfaY5U1q7F60WI2pdRegw&s=09" target="_blank" class="d-inline-block">
                    <span class="sr-only">twitter</span>
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="https://www.instagram.com/liftdedoo/" target="_blank" class="d-inline-block">
                    <span class="sr-only">Instagram</span>
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- enquiry modal -->
<div class="modal fade" id="enquiry-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Book My Enquiry</h4>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
			<button type="button" class="btn close submit btn-default" data-dismiss="modal"><i class="fa fa-times"
                        aria-hidden="true"></i></button>
          </div>
            <form id="enquiry-modal-form" method="POST" action="{{ url('store-inquiry') }}">
              <div class="modal-body">
                    <div class="box">
                        <div class="box-content">
                            @csrf
                            <p class="myride-content"> Please fill up below details to confirm your Enquiry Booking, we will inform you, if any cab available as per your criteria.</p> 
                            <p class="mandatory">(<em>*</em>) mandatory fields</p>
                            <div class="field required ui-widget">
                                <label class="label"><span>Pickup Location</span><span
                                        class="requard">*</span></label>
                                <input type="text" onChange="inquirycheckLocation(this.value)" id="inquiry_start_location" class="typeahead input-text"
                                    name="inquiry_start_location" placeholder="">
                                    <span id="inquiry_startSpinner" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span>
                                <div class="form-select" id="inquiry_locationsearch" style="color: red;font-size: 12px;"></div>
                            </div>
                            <input type="hidden" name="inquiry_strtLocId" id="inquiry_strtLocId">
                            <input type="hidden" name="inquiry_endLocId" id="inquiry_endLocId">
                            <div class="field required">
                                <label class="label"><span>Drop Location</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="inquiry_end_location" onChange="inquirycheckEndLocation(this.value)" class="input-text" name="inquiry_end_location"
                                    placeholder="">
                                    <span id="inquiry_startSpinnerEnd" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span>
                                    <div class="form-select" id="inquiry_locationsearch2" style="color: red;font-size: 12px;">
                                    </div>
                            </div>
                             {{-- calander --}}
                            <div class="field required w-100">
                                <label class="label mb-0" class="booking_dates" id="availabe-text"
                                    style="width: 100%"><span>Journey
                                        Date</span><span class="requard">*</span></label>
                                <div class="w-100">
                                    <input type="text"  readonly class="inq_booking_dates"
                                        id="inquiry_start_time" name="inquiry_start_time" value="" class="mt-2" autocomplete="off">
                                    <!-- <span class="" style="margin:0px 30px;">to</span>
                                    <input type="text" readonly class="booking_dates" id="inquiry_end_time" 
                                    name="inquiry_end_time" value=""
                                        class="mt-2"  autocomplete="off"> -->
                                </div>
                            </div>
                            {{-- calander --}}
                            <div class="field required">
                                <label class="label"><span>Phone Number</span><span
                                        class="requard">*</span></label>
                                <input type="text" id="inquiry_user_phone" class="input-text" name="inquiry_user_phone"
                                    placeholder="" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" >
                                    <!-- <span id="startSpinnerEnd" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span> -->
                                    
                            </div>
                            <div class="field last required">
                                <label class="label"><span>Message</span><span
                                        class="requard">*</span></label>
                                <div>
                                <textarea  id="inquiry_message"  class="input-text" name="inquiry_message"
                                    placeholder=""></textarea>
                                    <!-- <span id="startSpinnerEnd" style="display: none;margin-left: -29px;">
                                        <i class="fa fa-spinner"></i>
                                    </span> -->
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="inquiry_res_message" class="error"></div>
                        <div class="actions">
                            
                            <button type="submit" id="bookingBtn" class="btn submit btn-primary">Book My Enquiry</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- enquiry modal -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0DR1EWS09B"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0DR1EWS09B');
</script>
<script>
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = document.referrer;
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }
    
</script>
<script type="text/javascript">
   
    $('.enquiry-form').on('click',function(){ 
        $('#enquiry-modal').modal('show');
    });
    $('#enquiry-modal').on('hidden.bs.modal', function (e) {
      $(this)
        .find("input,textarea,select")
           .val('')
           .end()
           .find(".error")
           .text('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();
    })
    jQuery('#enquiry-modal-form').validate({
        rules: {
            inquiry_start_location: {
                required: true,
            },
            inquiry_start_time: {
                required: true,
            },
            inquiry_end_location: {
                required: true,
            },
            inquiry_user_phone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            inquiry_message: {
                required: true,
            },
        },
        messages: {
            inquiry_start_location: {
                required: "Please enter your pickup location",
            },
            inquiry_start_time: {
                required: "Please select journey date",
            },
            inquiry_end_location: {
                required: "Please enter your drop location",
            },
            inquiry_user_phone: {
                required: "Please enter your phone number",
                number: "Please enter only number",
                minlength: "Please enter valid 10 digit phone number",
                maxlength: "Please enter valid 10 digit phone number"
            },
            inquiry_message: {
                required: "Please enter your message",
            },
        },
        submitHandler: function(form) {
            //form.submit();
            $('#pageloader').show();
            $.ajax({
                url  : 'store-inquiry',
                type : 'POST',
                headers: {
                      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                data    : $('#enquiry-modal-form').serialize(),
                dataType : 'JSON'
            })
            .done(function(response){
                $('#pageloader').hide();
                $('#inquiry_res_message').html('<div class="alert alert-success">\
                            <button type="button" class="close" data-dismiss="alert">×</button>\
                            Your Enquiry submitted successfully,customer care executive will contact you soon.\
                        </div>');

                setTimeout(function(){
                     $('.alert-success').slideUp('slow').fadeOut();
                     location.reload();
                }, 2000);
            })
            .fail(function(error){
               $('#inquiry_res_message').html('<div class="alert alert-danger">\
                            <button type="button" class="close" data-dismiss="alert">×</button>\
                            '+error.responseJSON.message+'\
                        </div>');
                $('#pageloader').hide();
            });

        }
    });
    $(document).ready(function() {
        $("#inquiry_start_location").autocomplete({
            source: function(request, response) {
                var url = "{{ route('searchlocation') }}";
                $("#inquiry_startSpinner").fadeIn(500);
                $("#inquiry_startSpinner").fadeOut(500);
                $.ajax({
                    type: 'GET',
                    url: url, // http method
                    data: {
                        term: request.term,
                        startLocationId: $("#inquiry_endLocId").val(),
                        startLocationName: $("#inquiry_end_location").val(),
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
                            $("#inquiry_strtLocId").val(respId);
                            response(resp);
                            $("#inquiry_locationsearch").text('');
                        } else {
                            $("#inquiry_strtLocId").val('');
                            $("#inquiry_locationsearch").text("NO LOCATION FOUND");
                        }
                    }
                });
            },
            minLength: 2
        });
    
        $("#inquiry_end_location").autocomplete({
            source: function(request, response) {
                var url = "{{ route('searchlocation') }}";
                $("#inquiry_startSpinnerEnd").fadeIn(500);
                $("#inquiry_startSpinnerEnd").fadeOut(500);
                $.ajax({
                    type: 'GET',
                    url: url, // http method
                    data: {
                        term: request.term,
                        startLocationId: $("#inquiry_strtLocId").val(),
                        startLocationName: $("#inquiry_start_location").val(),
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
                            $("#inquiry_endLocId").val(respId);
                            response(resp);
                            $("#inquiry_locationsearch2").text('');
                        } else {
                            $("#inquiry_endLocId").val('');
                            $("#inquiry_locationsearch2").text("No location found");
                        }
                    }
                });
            },
            minLength: 2
        });

        var date = new Date();
        var addDays = date.setDate(date.getDate() + 6);
        $('.inq_booking_dates').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: 0,
            maxDate: 6,
            startDate: new Date(),
            endDate: new Date(addDays)
        });
    });

    function inquirycheckLocation(value) {
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
                    if($("#inquiry_locationsearch2").text() != "")
                    {
                        //$("#searchform").attr("disabled", true);
                    }
                    else
                    {
                        //$("#searchform").attr("disabled", false);
                    }
                } else {
                    $("#inquiry_locationsearch").text("No location found");
                    //$("#searchform").attr("disabled", true);
                }
            },
        });
    }

    function inquirycheckEndLocation(value) {
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
                    if($("#inquiry_locationsearch").text() != "")
                    {
                        //$("#searchform").attr("disabled", true);
                    }
                    else
                    {
                        //$("#searchform").attr("disabled", false);
                    }
                } else {
                    $("#inquiry_locationsearch2").text("No location found");
                    //$("#searchform").attr("disabled", true);
                }
            },
        });
    }
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/628f65ef7b967b1179915c48/1g402cctu';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<style type="text/css">
    .enquiry-form{
        cursor: pointer;
    }
    #enquiry-modal.modal.fade{
      z-index: 10000000 !important;
    }
    .ui-datepicker {
      z-index: 9999999999999 !important;
    }
    .ui-autocomplete {
        z-index: 9999999999999 !important;
    }
</style>
</body>

</html>
