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
                    <h3 class="mb-1 font-weight-bold">Availibality Booking List Table</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('driver-availability-booking-list') }}">
                                Availibality Booking List
                            </a>
                        </li>

                    </ol>
                </div>
                <a href="#" onclick="GoBackWithRefresh();return false;">
                    <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                </a>
            </div>
        </div>
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Driver</th>
                                            <th>Agency Name</th>
                                            <th>Start Location</th>
                                            <th>End Location</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Distance</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $user->drivername }}</td>
                                                @if($user->agencyName !="")
                                                <td>{{$user->agencyName}}</td>
                                                @else
                                                <td>--</td>
                                                @endif
                                                <td>{{ $user->startLocation }}</td>
                                                <td>{{ $user->endLocation }}</td>
                                                <td>{{date('d-m-Y H:i',strtotime($user->start_time))}}</td>
                                                <td>{{date('d-m-Y H:i',strtotime($user->end_time))}}</td>
                                                <td>{{ $user->distance }}</td>
                                                <td>{{ $user->distance_price }}</td>
                                                <td>
                                                    @if ($user->role == 1)
                                                        <span class="badge badge-soft-danger">Individual-Driver</span>
                                                    @elseif($user->role == 2 )
                                                        <span class="badge badge-soft-warning">Agency-Driver</span>
                                                    @endif
                                                </td>
                                                <td>
                                                @if($user->booking_confirm_status == "0")
                                                    <span class="badge badge-soft-info">Pending</span>
                                                @elseif($user->booking_confirm_status == "1")
                                                    <span class="badge badge-soft-success">Confirmed</span>
                                                @endif</td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->
            </div>
        </div>
    </div>
</div>
<!-- main content End -->
@include('admin.footer')
