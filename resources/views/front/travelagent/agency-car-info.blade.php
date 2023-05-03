@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<div class="overlay"></div>
<section class="dashboard mb-5">
    <div class="container travel-booking driver-availability-dashboard car-info">
        <div class="row">
            @include('front.include.agent-sidebar')
			
            <div class="col-right">
			<div class="title-srch">
                @if (session()->has('save'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('save') }}
                    </div>
                @elseif (session()->has('validity'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('validity') }}
                    </div>
                @elseif (session()->has('delete'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('delete') }}
                    </div>
                @elseif (session()->has('update'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('update') }}
                    </div>
                    @elseif (session()->has('limit'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('limit') }}
                    </div>
                @endif

                @if (count($agencyCarHistory) > 0)
                    <h1 class="title">Agencies Vehicle Info</h1>
					
	               
                    <div class="input-group search-date">
					<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                        <form method="POST" action="{{ url('searchAgencyVehicle') }}">
                            @csrf
                            <div class="input-group-append">
                                <input type="text" class="form-control" required placeholder="Search With Registration Number" name="search"
                                    id="search">

                                <button class="btn btn-secondary" type="submit" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
					  </div>
					  </div>
                        <a href="{{ url('agency-car-registration') }}"> <button type="button"
                                class="btn btn-secondary" aria-haspopup="true" aria-expanded="false"
                                style="margin-left:10px; border-color:#f42e00;background:#f42e00;">
                                Add More Vehicle
                            </button></a>
                    </div>
					</div>
				 
                    <div class="box">
                        <div class="box-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Vehicle Registration Number.</th>
                                            <th scope="col">Rate/km</th>
                                            <th scope="col">Vehicle Type</th>
                                            <th scope="col">Seating Capacity</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($agencyCarHistory as $list)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $list->vehicle_registration_number }}</td>
                                                <td>{{ $list->rate_per_km }}</td>
                                                <td>{{ $list->vehicle_name }}</td>
                                                <td>{{ $list->capacity }}</td>
                                                <td>
                                                    <a href="{{ url('edit-agency-car-info') }}/{{ $list->id }}"><button
                                                            type="button" class="btn btn-info waves-effect waves-light"
                                                            data-effect="wave"><i class="fa fa-pencil-square-o"
                                                                aria-hidden="true"></i></button></a>
                                                    <a
                                                        href="{{ url('Agency-vehicle-info/delete') }}/{{ $list->id }}">
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
                @else
                    <h1 class="title">Register Your Vehicle</h1>
                    <div class="box">
                        <div class="box-content">
                            <form id="agencyInfo" method="POST" action="{{ route('agency.car.info') }}">
                                @csrf
                                <p class="mandatory">(<em>*</em>) mandatory fields</p>
                                <div class="field required">
                                    <label class="label"><span>Vehicle Registration Number.</span><span
                                            class="requard">*</span></label>
                                    <input type="text" value="WB" id="vehicle_registration_number"
                                        class="input-text" name="vehicle_registration_number" placeholder=""
                                        onkeyup="this.value, '')">
                                    <span id="unique-car-error" style="display: none; color: red;">This Vehicle Number
                                        is
                                        Already
                                        Exists</span>
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Vehicle Rate/Km</span><span
                                            class="requard">*</span></label>
                                    <input type="text" id="rate_per_km" class="input-text" name="rate_per_km"
                                        placeholder="" onkeyup="this.value=this.value.replace(/[^0-9]/gi, '');">
                                </div>

                                <div class="field required last">
                                    <label class="label"><span> Vehicle Type</span><span
                                            class="requard">*</span></label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="vehicle_name" id="vehicle_name">
                                        <option selected="" value="" disabled="disabled">Select Your Vehicle</option>
                                        @foreach ($vehicleType as $list)
                                            <option value="{{ $list->id }}">{{ $list->vehicle_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="field required last">
                                    <label class="label"><span>Seating Capacity</span><span
                                            class="requard">*</span></label>
                                    <select name="capacity" class="form-select" aria-label="Default select example">
                                        <option selected="" value="" disabled="disabled">Select Seat Capacity</option>
                                        <option value="4+1">4+1</option>
                                        <option value="6+1">6+1</option>
                                    </select>
                                </div>
                                <div class="actions">
                                    <button type="submit" id="submit" class="btn submit btn-primary"
                                        name="send">submit</button>
                                    <input type="button" class="btn submit btn-primary" onclick="GoBackWithRefresh();return false;" value="Cancel">
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
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
    $(".alert").fadeTo(2000, 500).slideUp(1000, function() {
        $(".alert").slideUp(1000);
    });
    jQuery('#agencyInfo').validate({

        rules: {

            vehicle_registration_number: {
                required: true,
                minlength: 8,
                maxlength: 10,

            },
            vehicle_name: {
                required: true,
            },

            rate_per_km: {
                required: true,
                number: true
            },
            capacity: {
                required: true,
            },

        },
        messages: {
            vehicle_registration_number: {
                required: "Please enter your vehicle number",
                maxlength:"Maximum 10 characters allowed",
            },
            vehicle_name: {
                required: "Please select your vehicle type",
            },
            rate_per_km: {
                required: "Please enter your vehicle rate/km",
                number: "Please Enter Only Number"
            },
            capacity: {
                required: "Please select seating capacity",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $('#vehicle_registration_number').on('keyup change', function() {
        var vehicle_registration_number = this.value;
        var url = "{{ route('uniqueCarNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                vehicle_registration_number: vehicle_registration_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-car-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-car-error").css('display', 'none');
                    $("#submit").prop('disabled', false);
                    $("#submit").css('cursor', 'pointer');
                }
            },
        });
    });
    var readOnlyLength = $('#vehicle_registration_number').val().length;

    $('#output').text(readOnlyLength);

    $('#vehicle_registration_number').on('keypress, keydown', function(event) {
        var $vehicle_registration_number = $(this);
        $('#output').text(event.which + '-' + this.selectionStart);
        if ((event.which != 37 && (event.which != 39)) &&
            ((this.selectionStart < readOnlyLength) ||
                ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
            return false;
        }
    });
</script>
@include('front.include.footer')
