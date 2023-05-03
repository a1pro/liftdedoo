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
                <div class="page-title dflex-between-center">
                    <a href="{{ url('users-list') }}">
                        <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                    </a>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('users-list') }}">
                                Users List
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Driver Details</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Driver Details</h5>
                                <h6 class="card-subtitle">
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form>
                                            <div class="form-group">
                                                <label for="simpleinput">Name</label>
                                                <input type="text" id="simpleinput" readonly value="{{ $users->name }}"
                                                    disabled class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-password">Mobile Number</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $role->mobile }}" class="form-control" value="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-password">Age</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $users->age }}" class="form-control" value="password">
                                            </div>
                                        </form>
                                    </div> <!-- end col -->

                                    <div class="col-lg-6">
                                        <form>
                                            <div class="form-group">
                                                <label for="example-email">Email</label>
                                                <input type="email" id="example-email" value="{{ $role->email }}"
                                                    disabled name="example-email" class="form-control"
                                                    placeholder="Email">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-password">Gender</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $users->gender }}" class="form-control"
                                                    value="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-password">Licence Number</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $users->license_number }}" class="form-control"
                                                    value="password">
                                            </div>
                                        </form>
                                    </div> <!-- end col -->
                                    <div class="card-header" style="width:100%">
                                        <h5 class="card-title">Vehicle Details</h5>
                                    </div>
                                    @if (count($vehicles) > 0)
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <table id="datatable-buttons"
                                                        class="table table-striped dt-responsive nowrap w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Name</th>
                                                                <th>Vehicle Registration Number</th>
                                                                <th>Capacity</th>
                                                                <th>Rate Per KM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            @foreach ($vehicles as $vehicle)
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $vehicle->vehicle_name }}</td>
                                                                    <td>{{ $vehicle->vehicle_registration_number }}
                                                                    </td>
                                                                    <td>{{ $vehicle->capacity }}</td>
                                                                    <td>{{ $vehicle->rate_per_km }}</td>

                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                </div>

                            @else
                                <p>No vehicle added by Driver</p>
                                @endif

                            </div>
                            <!-- end row-->

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
<!-- main content End -->
</div>
<!-- main content End -->
@include('admin.footer')
