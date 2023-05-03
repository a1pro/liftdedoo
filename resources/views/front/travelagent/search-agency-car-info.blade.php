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
                @endif
                <h1 class="title">My vehicle info</h1>
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
                                        <th scope="col">Vehicle Number</th>
                                        <th scope="col">Rate/Km </th>
                                        <th scope="col">Vehicle Type</th>
                                        <th scope="col">Seat Capacity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>

                                    @foreach ($searchs as $list)
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
                                                    href="{{ url('driver-vehicle-info/delete') }}/{{ $list->id }}">
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
    </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script> -->
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
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    jQuery('#driverCarInfo').validate({

        rules: {

            vehicle_registration_number: {
                required: true,
                minlength: 9,
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
            },
            vehicle_name: {
                required: "Please select your vehicle type",
            },
            rate_per_km: {
                required: "Please enter your vehicle rate/km",
                number: "Please enter only number"
            },
            capacity: {
                required: "Please select seating capacity",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@include('front.include.footer')
