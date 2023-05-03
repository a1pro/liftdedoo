@include('admin.header')
<!-- Header End -->
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
                    <h3 class="mb-1 font-weight-bold">Paytm Details</h3></br>
                    
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('')}}">
                                Paytm Details
                            </a>
                        </li>
                        <li class="breadcrumb-item active"> Paytm Details</li>
                    </ol>
                </div>
            </a>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            @if (session()->has('change'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ session()->get('change') }}
                                </div>
                            @endif
                            <div class="card-body">
                                <form id="paytm" class="needs-validation" method="POST"
                                    action="{{ url('paytm-details-insert') }}" novalidate>
                                    @csrf

                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Environment</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm environment" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_environment }} @endif" required name="paytm_environment" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Merchant id</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm Merchant id" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_merchant_id }} @endif" required name="paytm_merchant_id" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Merchant Key</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm Merchant Key" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_merchant_key }} @endif" required name="paytm_merchant_key" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Merchant Website</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm website" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_merchant_website }} @endif" required name="paytm_merchant_website" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Channel</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm channel" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_channel }} @endif" required name="paytm_channel" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Paytm Industry Type</label>
                                        <input type="text" class="form-control map-input"  placeholder="enter paytm environment" value="@if (!empty($paytmDetails)){{ $paytmDetails->paytm_industry_type }} @endif" required name="paytm_industry_type" value="" required>
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
      jQuery('#paytm').validate({
        rules: {
            paytm_environment: {
                required: true,
            },
            paytm_merchant_id: {
                required: true,
            },
            paytm_merchant_key: {
                required: true,
            },
            paytm_merchant_website: {
                required: true,
            },
            paytm_channel: {
                required: true,
            },
            paytm_industry_type: {
                required: true,
            },

        },
        messages: {
            paytm_environment: {
                required: "Please Enter Paytm Environment",
            },
            paytm_merchant_id: {
                required: "Please Enter Paytm Merchant Id",
            },
            paytm_merchant_key: {
                required: "Please Enter Paytm Merchant Key",
            },
            paytm_merchant_website: {
                required: "Please Enter Paytm Merchant Website",
            },
            paytm_channel: {
                required: "Please Enter Paytm Channel",
            },
            paytm_industry_type: {
                required: "Please Enter Paytm Industry Type",
            },
            


        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
