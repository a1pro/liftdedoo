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
                            <a href="{{ url('/app/drivers') }}">
                                Driver List
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
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <!--<th>Details</th>-->
                                            <th>Action</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php $i = 1; ?>
                                        @foreach($driverdetails as $user)
                               
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{$user['name']}}</td>
                                                <td>{{  $user['mobile'] }} @if($user['mobile_verify_status'] == "1")
                                                    <i style="color: green;" class="bx bxs-badge-check"></i>
                                                @endif</td>
                                                    <td><span class="badge badge-soft-danger">Driver</span></td>
                                                    <td> profile : @if($user->profile_verification_status==1)
                                                            <span style="color:green;font-weight:bold;">verified</span>  
                                                            @else
                                                            <span style="color:orange;font-weight:bold;">un-verified</span>  
                                                            @endif
                                                    <br>
                                                            docs:
                                                            @if($user->document_verification_status==1)
                                                            <span style="color:green;font-weight:bold;">verified</span>  
                                                            @else
                                                            <span style="color:orange;font-weight:bold;">un-verified</span>  
                                                            @endif </td>
                                                    <td style="text-align: center">
                                                        <a href="{{ url('/admin/app/driver-details') }}/{{  $user->userid }}"><button type="button" class="btn btn-info waves-effect waves-light" data-effect="wave"><i class="fe-eye"></i></button></a>
                                                    </td>
                                                <!--<td>-->
                                                    <!-- @if ( $user['status']  == 1)
                                                    <!--    <a href="{{ url('users/status/0') }}/{{ $user['id'] }}"><button type="button" class="btn btn-warning waves-effect waves-ligh" data-effect="wave">Deactive</button></a>-->
                                                    <!--@elseif( $user['status'] ==0)-->
                                                    <!--    <a href="{{ url('users/status/1') }}/{{ $user['id'] }}"><button type="button" class="btn btn-success waves-effect waves-light" data-effect="wave">Active</button></a>-->
                                                    <!--@endif -->
                                                <!--</td>-->
                                                <td>
                                                <a onclick="return confirmalert()" href="{{ url('/admin/app/delete-user') }}/{{ $user->userid }}"><button type="button" class="btn btn-danger waves-effect waves-light" data-effect="wave"><i class="mdi mdi-delete"></i></button></a>
                                                </td>
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
<script>
// alert('ghd');
        function confirmalert()
        {
          let status = confirm("Do you really want to delete the driver");
          console.log(status);
          return status;
        }


    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
</script>
<!-- main content End -->
@include('app-admin.footer')
