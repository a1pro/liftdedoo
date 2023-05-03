@include('front.include.header')
<style>
    label#email-error {
        width: 100%;
    }

</style>

<section class="contact mb-5">
    <div class="container login-main">
        <div class="row">
            <h1 class="title text-center">Forget Password</h1>
            <div class="wrapper">
                <div id="formContent">
                    <!-- Login Form -->
                    <form id="user_login" method="POST" action="{{ url('forget-password') }}">
                        @csrf
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>
                        <input type="hidden" name="mobile" value="{{ $mobile }}">
                        <label class="label"><span>New Password</span><span
                                class="requard">*</span></label>
                        <input type="password" id="new_password" class="input-text" name="new_password"
                            placeholder="" value="">
                        <label style="white-space: pre-wrap;" class="label"><span>Confirm Password</span><span
                                class="requard">*</span></label>
                        <input type="password" id="new_confirm_password" class="input-text"
                            name="new_confirm_password" placeholder="">
                        <div class="actions">
                            <button type="submit" class="btn login-btn btn-primary">submit</button>
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
            new_password: {
                required: true,
                minlength: 7,
                maxlength: 25,

            },
            new_confirm_password: {
                required: true,
            },

        },
        messages: {
            new_password: {
                required: "Please enter your new password",

            },
            new_confirm_password: {
                required: "Please enter your confirm password",
            }

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@include('front.include.footer')
