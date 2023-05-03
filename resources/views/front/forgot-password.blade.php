@include('front.include.header')
<style>
    label#email-error {
        width: 100%;
    }

</style>
<section class="contact forget mb-5">
    <div class="container login-main">
        <div class="row">
            <h1 class="title text-center">Forgot Password</h1>
            <div class="wrapper">
                <div id="formContent">
                    <!-- Login Form -->
                    @if (session()->has('status'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('status') }}
                    </div>
                    @elseif(session()->has('cancel'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session()->get('cancel') }}
                    </div>
                    @endif
                    <form id="user_login" class="otp" method="POST" action="{{ url('checkOtp') }}">
                        @csrf
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>

                        <label class="label"><span>Phone Number</span><span
                                class="requard">*</span></label>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="otp-2">
                                    <input type="text" id="mobile" class="input-text mb-0" placeholder="Mobile Number"
                                        style="width: 200px;" name="mobile" placeholder="" value="">
                                </div>
                            </div>
                            <div class="col-lg-4 otp-3 p-0">
                                <button type="submit" id="send" class="btn send btn-primary mx-2">send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
   
    jQuery('#user_login').validate({
        rules: {
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
        },
        messages: {
            email: {
                required: "Please enter your phone number",
                number: "Please enter only number",
                minlength: "Mobile number must be 10 Digits",
                maxlength: "Mobile number must be 10 Digits"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
@include('front.include.footer')
