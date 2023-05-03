@include('admin.header')
<!-- Header End -->
<!-- Header End -->
<!-- Begin Left Navigation -->
<!-- Begin Left Navigation -->
@include('admin.sidebar')
<!-- Left Navigation End -->
<!-- Left Navigation End -->
<!-- Begin main content -->
<div class="main-content">
    <!-- content -->
    <div class="page-content">
        <!-- page header -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-5 col-xl-6">
                        <div class="page-title">
                            <h3 class="mb-1 font-weight-bold">LiftDeddo</h3>
                            <ol class="breadcrumb mb-3 mb-md-0">
                                <li class="breadcrumb-item active">Welcome to Admin Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <!-- Widget  -->


                </div>
                <!-- Row 5 -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Liftdeddo Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <span>You Have  <span style="color:red"> ({{Helper::getNewRequestCount()}})</span> new booking request</span>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content End -->
@include('admin.footer')
