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
                    <h3 class="mb-1 font-weight-bold">@if($status == "0")New Booking Request Table @elseif($status == "1")Confirm Booking Request Table @else Cancel Booking list @endif</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('booking-requests') }}">
                            @if($status == "0")New Booking Request @elseif($status == "1")Confirm Booking Request @else Cancel Booking Request @endif
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
                                @if (session()->has('status'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('status') }}
                                    </div>
                                @elseif (session()->has('cancel'))
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('cancel') }}
                                    </div>
                                @endif
                                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Customer Name</th>
                                                <th>Start Location</th>
                                                <th>End Location</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Payment Option</th>
                                                <th>Price</th>
                                                <th>Details</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($bookings as $booking)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $booking['customer_name'] }}</td>

                                                    <td>{{ $booking['startLocation'] }}</td>
                                                    <td>{{ $booking['endLocation'] }}</td>
                                                    <td>{{date('d-m-Y H:i',strtotime($booking['startTime'] ))}}</td>
                                                    <td>{{date('d-m-Y H:i',strtotime($booking['endTime'] ))}}</td>
                                                    <td>
                                                        @if ( $booking['payment_option']  == 0)
                                                            15% Advance Payment
                                                        @elseif( $booking['payment_option'] ==1)
                                                            5% Advance Payment
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking['price'] }}</td>
                                                        <td style="text-align: center">
                                                            <a href="{{ url('driver-customer-details') }}/{{  $booking['id'] }}"><button type="button" class="btn btn-info waves-effect waves-light" data-effect="wave"><i class="fe-eye"></i></button></a>
                                                        </td>
                                                    @if($status == "0")
                                                        <td style="text-align: center">
                                                            <a href="{{ url('confirm-payment') }}/{{  $booking['id'] }}"><button type="button" class="btn btn-success waves-effect waves-light" data-effect="wave"><i class="fe-check"></i></button></a>
                                                            <a href="{{ url('cancel-payment') }}/{{  $booking['id'] }}"><button type="button" class="btn btn-danger waves-effect waves-light" data-effect="wave"><i class="mdi mdi-close-box"></i></button></a>
                                                        </td>
                                                    @elseif($status == "1")
                                                        <td><span class="badge badge-soft-success">Confirmed</span></td>
                                                    @elseif($status == "2")
                                                        @if($booking['status'] == "2")
                                                        <td><span class="badge badge-soft-danger">Canceled By Admin</span></td>
                                                        @elseif($booking['status'] == "3")
                                                        <td><span class="badge badge-soft-info">Canceled By Customer</span></td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end card body-->
                            </div>
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->
            </div>
        </div>
    </div>
</div>
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
<!-- main content End -->
@include('admin.footer')
