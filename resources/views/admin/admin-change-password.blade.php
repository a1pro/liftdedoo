@include('admin.header')
<!-- Begin Left Navigation -->
@include('admin.sidebar')
<!-- Left Navigation End -->
<!-- Begin main content -->
<div class="main-content">
    <!-- content -->
    <div class="page-content">
        <!-- page header -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="page-title dflex-between-center">
                    <h3 class="mb-1 font-weight-bold">Change Password Form</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item active">Change Password Form</li>
                    </ol>
                    <a href="#" onclick="GoBackWithRefresh();return false;">
                        <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                    </a>

                </div>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                            @if (session()->has('change'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('change') }}
                            </div>
                            @endif
                            </div>
                            <div class="card-body">
                                <form id="vehicle" class="needs-validation" method="POST"
                                    action="{{ route('admin.change.password') }}" novalidate>
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach

                                    @csrf
                                    <div class="form-group">
                                        <label for="validation-fname">Current Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Current Password" name="current_password" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">New Password</label>
                                        <input type="password" class="form-control" id="new_password"
                                            placeholder="New Password" name="new_password" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">New Confirm Password</label>
                                        <input type="password" class="form-control" id="new_confirm_password"
                                            placeholder="Confirm Password" name="new_confirm_password" value=""
                                            required>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
  
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });

    jQuery('#vehicle').validate({
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
                required: "Please Enter Current Password",
            },
            new_password: {
                required: "Please Enter New Password",
            },
            new_confirm_password: {
                required: "Please Enter New Confirm Password",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
