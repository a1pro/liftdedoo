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
                    <h3 class="mb-1 font-weight-bold">Driver-Customer Details</h3>
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
                        <li class="breadcrumb-item active">Driver-Customer Details</li>
                    </ol>
                </div>
                @if ($booking->status == '0')
                <a href="{{ url('booking-requests/0') }}">
                    <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                </a>
                @elseif($booking->status == "1")
                <a href="{{ url('booking-requests/1') }}">
                    <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                </a>
                @else
                <a href="{{ url('booking-requests/2') }}">
                    <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
                </a>
                @endif

            </div>
            </li>
            <li class="breadcrumb-item active">Driver-Customer Details</li>
            </ol>
        </div>

    </div>
    <!-- page content -->
    <div class="page-content-wrapper mt--45">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display:flex">
                                <h5 class="card-title col-md-3" style="color:green;">Driver Details</h5>
                                <h5 class="card-title col-md-3" style="color:red;">Customer Details</h5>
                                <h5 class="card-title col-md-3" style="color:blue;">Booking Details</h5>
                                <h5 class="card-title" style="color:blue;">Payment Details</h5>
                            </div>
                            <h6 class="card-subtitle">
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div>
                                        <label for="simpleinput">Driver Name: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $driver->name }}</label>
                                    </div>
                                    <?php $vehicleName = App\Models\VehicleType::vehicleName($vehicle->vehicle_type_id); ?>
                                    <div>
                                        <label for="simpleinput">Vehicle Name: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $vehicleName }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Driver Vehicle Register Number: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $vehicle->vehicle_registration_number }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Vehicle Rate Per Km: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $vehicle->rate_per_km }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Vehicle Capacity: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $vehicle->capacity }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Driver Licence Number: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $driver->license_number }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Driver Mobile Number: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $driver->mobile }}</label>
                                    </div>
                                </div> <!-- end col -->

                                <div class="col-lg-3">
                                    <div>
                                        <label for="example-email">Customer Name: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $booking->customer_name }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Customer Email: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $booking->customer_email }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Customer Address: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $booking->customer_address }}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Customer Mobile: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{ $booking->customer_mobile_number }}</label>
                                    </div>
                                </div> <!-- end col -->

                                <div class="col-lg-3">
                                    <div>
                                        <label for="example-password">Booking Time: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{date('d-m-Y H:i',strtotime($booking->bookingTime))}}</label>
                                    </div>
                                    <div>
                                        @if($booking->status == "2" || $booking->status == "3" )
                                            @if($booking->cancel_time !="")
                                            <label for="example-password">Cancel Time: </label>
                                            <label for="simpleinput" style="font-size: 18px;">{{date('d-m-Y H:i',strtotime($booking->cancel_time))}}</label>
                                            @endif
                                        @endif
                                    </div>
                                    <div>
                                        <label for="example-email">Start Location: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{$booking->startLocation}}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">End Location: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{$booking->endLocation}}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Start Time: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{date('d-m-Y H:i',strtotime($booking->start_time))}}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">End Time: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{date('d-m-Y H:i',strtotime($booking->end_time))}}</label>
                                    </div>
                                    <div>
                                        <label for="example-password">Total Price: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{$booking->distance_price}}</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                   
                                    <div>
                                        <label for="example-password">Payment Type: </label>
                                        <label for="simpleinput" style="font-size: 18px;">
                                            @if ( $booking->payment_option == 0)
                                            <span class="badge badge-soft-info">15% Advance Payment</span>
                                            @elseif( $booking->payment_option == 1)
                                            <span class="badge badge-soft-success">5% Advance Payment</span>
                                            @endif</label>
                                    </div>
                                    <div>
                                        @if ( $booking->order_id != "")
                                        <label for="example-password">Order Id: </label>
                                        <label for="simpleinput" style="font-size: 18px;">
                                        {{$booking->order_id}}
                                        </label>
                                        @endif
                                    </div>
                                    @if ( $booking->transaction_id != "")
                                    <div>
                                        <label for="example-password">transaction Id: </label>
                                        <label for="simpleinput" style="font-size: 18px;">
                                        {{$booking->transaction_id}}
                                        </label>
                                    </div>
                                    @endif
                                    @if ( $booking->paytm_payment_status != "")
                                    
                                    <div>
                                        <label for="example-password">Payment Status: </label>
                                        <label for="simpleinput" style="font-size: 18px;">
                                        @if ( $booking->paytm_payment_status == 1)
                                            <span class="badge badge-soft-success">Success</span>
                                            @elseif( $booking->paytm_payment_status == 0)
                                            <span class="badge badge-soft-danger">Failed</span>
                                            @elseif( $booking->paytm_payment_status == 2)
                                            <span class="badge badge-soft-warning">Processing</span>
                                            @endif
                                        </label>
                                    </div>
                                    @endif
                                    
                                    @if ( $booking->payment_amount != "")
                                    <div>
                                        <label for="example-password">Payment Price: </label>
                                        <label for="simpleinput" style="font-size: 18px;">{{$booking->payment_amount}}</label>
                                    </div>
                                    @endif

                                    <div>
                                        <label for="example-password">Booking Status: </label>
                                        <label for="simpleinput" style="font-size: 18px;">
                                            @if($booking->status == "0")
                                            <span class="badge badge-soft-info">Pending</span>
                                            @elseif($booking->status == "1")
                                            <span class="badge badge-soft-success">Confirmed</span>
                                            @else
                                            <span class="badge badge-soft-danger">Canceled</span>
                                            @endif</label>
                                    </div>
                                </div>
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