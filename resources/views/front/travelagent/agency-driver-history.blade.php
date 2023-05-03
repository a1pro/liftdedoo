@include('front.include.header')
<div class="overlay"></div>
<section class="dashboard mb-5">
    <div class="container booking-dashboard">
        <div class="row">
            @include('front.include.agent-sidebar')
            <div class="col-right">
			<div class="title-srch">
                @if (session()->has('save'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('save') }}
                    </div>
                @endif
                <h1 class="title">Agencies Driver Details</h1>
                <div class="input-group search-date">
				<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                   </div>
				   </div>
                    <a href="{{ url('agency-driver-info') }}"> <button type="button" class="btn btn-secondary"
                        aria-haspopup="true" aria-expanded="false"
                        style="margin-left:10px; border-color:#f42e00;background:#f42e00;">
                        Add Driver
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
                                        <th scope="col">Driver Name</th>
                                        <th scope="col">Driver Age</th>
                                        <th scope="col">Driver Mobile Number</th>
                                        <th scope="col">Driver License Numbe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($agencydriver as $list)

                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ $list->age }}</td>
                                            <td>{{ $list->mobile }}</td>
                                            <td>{{ $list->license_number }}</td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
@include('front.include.footer')
