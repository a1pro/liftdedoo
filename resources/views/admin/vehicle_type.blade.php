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
                    <h3 class="mb-1 font-weight-bold">VehicleTable</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('vehicle')}}">
                                VehicleTable
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
                                <h5 class="card-title" style="float: right;"><a href="{{ url('vehicle-form') }}"
                                        class="btn btn-primary waves-effect waves-light" data-effect="wave"><i
                                            class="bx bx-plus bx-flashing"></i> Add Vehicle</a></h5>
                            </div>
                            <div class="card-body">
                                @if (session()->has('delete'))
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('delete') }}
                                    </div>
                                @elseif (session()->has('success'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Vehicle</th>
                                            <th>Seat Capacity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($vehicles as $list)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $list->vehicle_name }}</td>
                                                <td>{{ $list->seat_capacity }}</td>
                                                <td>
                                                    <a href="{{ url('vehicle-form') }}/{{ $list->id }}"><button
                                                            type="button" class="btn btn-info waves-effect waves-light"
                                                            data-effect="wave"><i class="fe-edit"></i></button>
                                                    </a>
                                                    <button
                                                            type="button" class="btn btn-danger waves-effect waves-light"
                                                            data-effect="wave" onclick="deletedata(<?php echo $list->id ?>)"> <i class="mdi mdi-delete"></i></button>
                                                    </a>
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
<!-- main content End -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
<script>
   $(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});
function  deletedata(id)
        {
            var id = id;
            swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            type: 'warning',
            showCancelButton: true,
            }).then(function(value) {
              console.log(value);
                if (value.value == true) {
                    $.ajax({
                        type: 'post',

                        data: {
                            _token:'{{ csrf_token() }}',
                            id: id
                        },
                        url: "delete_vehicle",
                        success: function (data) {
                          if(data == 0)
                          {
                             swal("Deleted!", "Your Record deleted.", "success");
                            setInterval(function(){
                              location.reload();
                            }
                                        , 1500);
                            //
                          }
                        }
                    });
                }
            });
        }

 </script>
@include('admin.footer')
