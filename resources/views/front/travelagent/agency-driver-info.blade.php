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
                @if (count($driver) > 0)
                    <h1 class="title">Agencies Driver Info</h1>
                    <div class="input-group search-date">
					<div class="fixed-search">
					<button type="button" class="slide-toggle search-btn"><i class="fa fa-search"></i></button>
					<div class="srch-box">
                        <form method="POST" action="{{ url('searchDriver') }}">
                            @csrf
                            <div class="input-group-append">
                                <input type="text" class="form-control" required placeholder="Search With Licence Number" name="search"
                                    id="search">

                                <button class="btn btn-secondary" type="submit" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                        </form>
						</div>
						</div>
                        <a href="{{ url('agency-driver-registration') }}"> <button type="button"
                                class="btn btn-secondary" aria-haspopup="true" aria-expanded="false"
                                style="margin-left:10px; border-color:#f42e00;background:#f42e00;">
                                Add More Driver
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
                                            <th scope="col">Driver License Number</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($driver as $list)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $list->name }}</td>
                                                <td>{{ $list->age }}</td>
                                                <td>{{ $list->mobile }}</td>
                                                <td>{{ $list->license_number }}</td>
                                                <td>
                                                    <a
                                                        href="{{ url('edit-agency-driver-info') }}/{{ $list->id }}"><button
                                                            type="button" class="btn btn-info waves-effect waves-light"
                                                            data-effect="wave"><i class="fa fa-pencil-square-o"
                                                                aria-hidden="true"></i></button></a>
                                                    <a
                                                        href="{{ url('agency-driver-info-delete/delete') }}/{{ $list->id }}">
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
                    <h1 class="title">Register Your Driver </h1>
                    <div class="box">
                        <div class="box-content">
                            <form id="agencyReg" method="POST" action="{{ route('agency.driver.info') }}">
                                @csrf
                                <p class="mandatory">(<em>*</em>) mandatory fields</p>
                                <div class="field required">
                                    <label class="label"><span>Driver Name</span><span
                                            class="requard">*</span></label>
                                    <input type="text" placeholder="" name="name" class="input-text" id="name"
                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Driver Age</span><span
                                            class="requard">*</span></label>
                                    <input type="number" placeholder="" min="18" max="60" name="age" id="age">
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Driver Sex</span><span
                                            class="requard">*</span></label>
                                    <select class="form-select droup required" aria-label="Default select example"
                                        name="gender">
                                        <option selected="" value="" disabled="disabled">Select Driver Sex</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Driver Mobile number</span><span
                                            class="requard">*</span></label>
                                    <input type="text" placeholder="" name="mobile" class="input-text" id="mobile"
                                        onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                    <span id="unique-mob-error" style="display: none; color: red;">This Mobile Number is
                                        Already
                                        Exists</span>
                                </div>
                                <div class="field required">
                                    <label class="label"><span>Driver License number</span><span
                                            class="requard">*</span></label>
                                    <input type="text" value="WB" placeholder="" name="license_number"
                                        class="input-text" id="license_number"
                                        onkeyup="this.value=this.value.replace(/[^a-z0-9 /-]/gi, '');">
                                    <span id="unique-lic-error" style="display: none; color: red;">This License Number
                                        is
                                        Already Exists</span>
                                </div>
                                <input type="hidden" name="role" value="1">
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
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
    jQuery('#agencyReg').validate({

        rules: {

            name: {
                required: true,
            },
            age: {
                required: true,
                number: true,
            },
            gender: {
                required: true,
            },
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            license_number: {
                required: true,
                minlength: 9,
                maxlength: 15,
            },

        },
        messages: {

            name: {
                required: "Please enter your driver name",
            },
            age: {
                required: "Please enter your driver age",
                number: "Please enter only number",
            },
            gender: {
                required: "Please enter your sex",
            },
            mobile: {
                required: "Please enter your driver mobile number",
                number: "Please enter only number",
                minlength: "Please enter valid mobile number",
                maxlength: "Please enter valid mobile number"
            },
            license_number: {
                required: "Please enter your driver license number",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#mobile').on('keyup change', function() {
        var mobile = this.value;
        var url = "{{ route('uniqueMobileNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                mobile: mobile,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-mob-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-mob-error").css('display', 'none');
                    if ($("#unique-lic-error").css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer')
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });

    $('#license_number').on('keyup change', function() {
        var license_number = this.value;
        var url = "{{ route('uniqueLicenseNumber') }}"
        $.ajax({
            type: 'POST',
            url: url, // http method
            data: {
                _token: "{{ csrf_token() }}",
                license_number: license_number,
            },
            success: function(data) {
                if (data == '1') {
                    $("#unique-lic-error").css('display', 'block');
                    $("#submit").prop('disabled', true);
                    $("#submit").css('cursor', 'not-allowed');
                } else {
                    $("#unique-lic-error").css('display', 'none');
                    if ($("#unique-mob-error").css('display') == 'block') {
                        $("#submit").prop('disabled', true);
                        $("#submit").css('cursor', 'pointer')
                    } else {
                        $("#submit").prop('disabled', false);
                        $("#submit").css('cursor', 'pointer');
                    }
                }
            },
        });
    });
</script>
@include('front.include.footer')
