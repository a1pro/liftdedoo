@include('front.include.header')
<style>
    label#email-error {
        width: 100%;
    }

</style>

<section class="contact mb-5">
    <div class="container login-main">
        <div class="row">
            <h1 class="title text-center">Change Password</h1>
            <div class="wrapper">
                <div id="formContent">
                    <!-- Login Form -->
                    <form id="user_login" method="POST" action="{{ route('change.password') }}">
                        @csrf
                        @error('current_password')
                        <p style="color: red;">Your current password does not match</p>
                        @enderror
                        @error('new_confirm_password')
                        <p style="color: red;">The new password and confirm password does not match</p>
                        @enderror
                        <p class="mandatory">(<em>*</em>) mandatory fields</p>
                        <label class="label"><span>Current Password</span><span
                                class="requard">*</span></label>
                        <input type="password" id="password" class="input-text" placeholder="" value=""
                            name="current_password" autocomplete="current-password">

                        <label style="white-space: pre-wrap;" class="label"><span>New Password</span><span
                                class="requard">*</span></label>
                        <input type="password" id="new_password" class="input-text" name="new_password"
                            placeholder="" autocomplete="current-password">

                        <label style="white-space: pre-wrap;" class="label"><span>Confirm New Password</span><span class="requard">*</span></label>
                        <input type="password" id="new_confirm_password" class="input-text"
                            name="new_confirm_password" placeholder="" autocomplete="current-password">

                        <div class="actions">
                            <button type="submit" class="btn login-btn btn-primary">Submit</button>
                            <input type="button" class="btn login-btn btn-primary" onclick="GoBackWithRefresh();return false;" value="Cancel">
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
            current_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 7,
                maxlength: 25,
            },
            new_confirm_password: {
                required: true,
            }

        },
        messages: {
            current_password: {
                required: "Please enter your current password",
            },
            new_password: {
                required: "Please enter your new password",
            },
            new_confirm_password: {
                required: "Please enter your new confirm password again",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@include('front.include.footer')
