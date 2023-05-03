@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="row justify-content-center">
                    <!--<div class="col-md-6 pr-md-0 left">
                        <div class="auth-page-sidebar">
                            <div class="overlay"></div>
                            <div class="auth-user-testimonial">
                                <div class="owl-carousel">
                                    <div class="item">
                                        <h3 class="text-white mb-1">I love this theme!</h3>
                                        <h5 class="text-white mb-3">"Admin templete. I love it very much!"</h5>
                                        <p>- Admin User</p>
                                    </div>
                                    <div class="item">
                                        <h3 class="text-white mb-1">I love this theme!</h3>
                                        <h5 class="text-white mb-3">"Admin templete. I love it very much!"</h5>
                                        <p>- Admin User</p>
                                    </div>
                                    <div class="item">
                                        <h3 class="text-white mb-1">I love this theme!</h3>
                                        <h5 class="text-white mb-3">"Admin templete. I love it very much!"</h5>
                                        <p>- Admin User</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-12 login-sec pl-md-0">
                        <div class="card mb-0 p-2 p-md-3">
                            <div class="card-body">
                                <div class="clearfix">
                                    <img src="{{ asset('admin/images/logo.png') }}" height="24" alt="Lettstart Admin">
                                </div>
                                <h5 class="mt-4 font-weight-600">Welcome back!</h5>
                                <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                                <form id="admin_login" method="POST" action="{{ route('login') }}" novalidate>
                                    @csrf
                                    @if ($message = Session::get('login-random'))
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>Email and Password doesn't Match</strong>
                                        </span>
                                    @endif
                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email') }}" autocomplete="email"
                                            placeholder="Enter Your Email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="password" autocomplete="current-password"
                                            placeholder="Enter Your Password" />
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="remember">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary btn-block" data-effect="wave" type="submit">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        jQuery('#admin_login').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,

                },

            },
            messages: {

                email: {
                    required: "Please enter email",
                    email: "Please enter valid email",
                },
                password: {
                    required: "Please enter your password",

                },

            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>
@endsection
