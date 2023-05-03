@include('app-admin.header')
<!-- Header End -->
<!-- Begin Left Navigation -->
@include('app-admin.sidebar')
<!-- Left Navigation End -->
<!-- Begin main content -->
<div class="main-content">
    <!-- content -->
    <div class="page-content">
        <!-- page header -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="page-title dflex-between-center">
                    <h3 class="mb-1 font-weight-bold">Driver List Table</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('paytm-payment') }}">
                                Payment List
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
                                @if (session()->has('status'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('status') }}
                                    </div>
                                @endif
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Distance</th>
                                            <th>Distance Price</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Payment Status</th>
                                            <th>Online Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          <?php $i = 1; ?>
                                        @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{$payment->distance}}</td>
                                            <td>{{$payment->distance_price}}</td>
                                            <td>{{$payment->start_time}}</td>
                                            <td>{{$payment->end_time}}</td>
                                            <td>{{$payment->payment_status}}</td>
                                            <td>{{$payment->online_status}}</td>
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
@include('app-admin.footer')
