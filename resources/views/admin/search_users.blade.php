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
                    <h3 class="mb-1 font-weight-bold">Search Users List Table</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('search-users-list') }}">
                                Search Users List
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
                                            <th>Pickup Location</th>
                                            <th>Drop Location</th>
                                            <th>Date</th>
                                            <!-- <th>End Date</th> -->
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($searchusers as $key => $inq)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{$inq->search_start_location}}</td>
                                                <td>{{$inq->search_end_location}}</td>
                                                <td>{{$inq->search_date}}</td>
                                                <!-- <td>{{$inq->inquiry_end_time}}</td> -->
                                                <td>{{$inq->search_user_phone}}</td>
                                                <td>
                                                    @if ( $inq->status  == 'INACTIVE')
                                                        <a href="{{ url('search-users/status/ACTIVE') }}/{{ $inq->id }}" onclick="return confirm('Do you want to change the Status?');" ><button type="button" class="btn btn-warning waves-effect waves-ligh" data-effect="wave">Deactive</button></a>
                                                    @elseif( $inq->status =='ACTIVE')
                                                        <a href="{{ url('search-users/status/INACTIVE') }}/{{ $inq->id }}" onclick="return confirm('Do you want to change the Status?');" ><button type="button" class="btn btn-success waves-effect waves-light" data-effect="wave">Active</button></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('delete-searchuser') }}/{{  $inq->id }}" onclick="return confirm('Do you want to delete?');"><button type="button" class="btn btn-danger waves-effect waves-light" data-effect="wave"><i class="mdi mdi-delete"></i></button></a>
                                                </td>
                                            </tr>
                                           
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
<script>
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
<!-- main content End -->
@include('admin.footer')
