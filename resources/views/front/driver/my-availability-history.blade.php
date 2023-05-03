@include('front.include.header')
<div class="overlay"></div>
<section class="dashboard mb-5">
    <div class="container booking-dashboard">
        <div class="row">
            @include('front.include.sidebar')
            <div class="col-right">
			<div class="title-srch">
                @if (session()->has('booking'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('booking') }}
                    </div>
                @endif
                <h1 class="title"> My Availability History</h1>
                <div class="input-group search-date">
				<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                    <input type="text" class="form-control" placeholder="Select date">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
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
                                        <th scope="col">#</th>
                                        <th scope="col">Available location</th>
                                        <th scope="col">Destination Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($booking as $list)
                                        <tr>
                                            <th scope="row">{{ $i }}</th>

                                            <td>{{ $list->startLocation }}</td>
                                            <td>{{ $list->endLocation }}</td>

                                            <td></td>
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
</section>
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
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
<!--Section: Contact v.2-->
@include('front.include.footer')
