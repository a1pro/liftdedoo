@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="section cms-banner d-flex align-items-center">
    <div class="overlay"></div>
    <h1 class="title text-center">contact us</h1>
</section>
<style>
    
textarea#g-recaptcha-response {
    display: none !important;
}
</style>
<!--Section: Contact v.2-->
<section class="contact mb-5">
    <!--Section description-->
    <p class="text-left txt w-responsive mx-auto mb-4 mt-4">Do you have any questions? Please do not hesitate to contact
        us directly. Our team will come back to you within
        a matter of hours to help you.</p>
    <div class="container contact-main">
        <div class="row">
            <!--Grid column-->
            <div class="col-md-9 left-side mb-md-0 mb-5">
                <form id="contact-form" name="contact-form" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <!--Grid row-->
                    <div class="row">
                        <!--Grid column-->
                        <div class="col-md-4">
                            <div class="md-form">
                                <label for="name" class="">
								<span>Your name</span>
								<span class="requard">*</span>
								</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)">
                            </div>
                        </div>
                        <!--Grid column-->
                        <!--Grid column-->
                        <div class="col-md-4">
                            <div class="md-form">
                                <label for="email" class="">
								<span>Your email (optional)</span>
								</label>
                                <input type="text" id="email" name="email" onkeyup="primaryEmail(this.value)"
                                    class="form-control">
                                <span style="color: red;" id="primaryEmailError"></span>
                            </div>
                        </div>
                        <!--Grid column-->
                        <div class="col-md-4">
                            <div class="md-form">
                                <label for="name" class="">
								<span>Phone</span>
								<span class="requard">*</span>
								</label>
                                <input type="text" id="mobile" name="mobile" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="subject" class="">
								<span>Subject</span>
								<span class="requard">*</span>
								</label>
                                <input type="text" id="subject" name="subject" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->
                    <!--Grid row-->
                    <div class="row">
                        <!--Grid column-->
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="message">
								<span>Your message</span>
								<span class="requard">*</span>
								</label>
                                <textarea type="text" id="message" name="message" rows="2"
                                    class="form-control md-textarea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6Lel48EdAAAAAG0wBB9j_mpKbMhru67rkCpz8o1C"></div>
                    <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" data-callback="recaptchaCallback">
                    <!--Grid row-->
                    <div class="text-center text-md-left">
                        <button type="submit" id="hidebtn" class="btn btn-primary" value="Send">Send
                    </div>
                    <div class="status">
                        @if (Session::has('msg'))
                            <p style="margin-top: 5px; color:red;">{{ Session::get('msg') }}</p>
                        @endif
                    </div>
            </div>
            </form>
            <!--Grid column-->
            <!--Grid column-->
            <div class="col-md-3 right-sidebar text-center">
                <ul class="list-unstyled mb-0">
                    <li><i class="fa fa-map-marker" aria-hidden="true"></i></i>
                        <p>{{ $contact->address }}</p>
                    </li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i>
                        <p>{{ $contact->mobile }}</p>
                    </li>
                    <li><i class="fa fa-envelope" aria-hidden="true"></i>
                        <p>{{ $contact->email }}</p>
                    </li>
                </ul>
            </div>
            <!--Grid column-->
        </div>
    </div>
</section>
<!--Section: Contact v.2-->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    function primaryEmail(primaryemail) {
        var email = primaryemail;
        // console.log(email);
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {
            $("#primaryEmailError").text('Please enter valid email');
            $("#hidebtn").attr("disabled", true);
        } else {
            $("#primaryEmailError").text('');
            $("#hidebtn").removeAttr("disabled");
        }
    }
    jQuery('#contact-form').validate({
        ignore: ".ignore",
        rules: {
            name: {
                required: true,
            },
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },

            subject: {
                required: true,
            },
            message: {
                required: true,
            },
            hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        messages: {
            name: {
                required: "Please enter your name",

            },
            mobile: {
                required: "Please Enter Your Mobile Number",
                number: "Please Enter Only Number",
                minlength: "please Enter valid Mobile Number",
                maxlength: "please Enter valid Mobile Number"
            },

            subject: {
                required: "Please enter your subject",

            },
            message: {
                required: "Please enter your message",
            },
            hiddenRecaptcha: {
                required: "Please enter captcha",

            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    function recaptchaCallback() {
  $('#hiddenRecaptcha').valid();
};
</script>
@include('front.include.footer')
