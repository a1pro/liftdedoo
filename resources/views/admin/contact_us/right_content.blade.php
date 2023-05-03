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
                    <h3 class="mb-1 font-weight-bold">Right Content Table</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('right-contact')}}">
                                Right Content List
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
                                <table id="scroll-horizontal-datatable" class="table ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($rightcontact as $list)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $list->address }}</td>
                                                <td>{{ $list->mobile }}</td>
                                                <td>{{ $list->email }}</td>
                                                <td style="text-align: center">
                                                    <a href="{{ url('edit-right-contact') }}/{{ $list->id }}"><button type="button" class="btn btn-warning waves-effect waves-light" data-effect="wave"><i class="fe-edit"></i></button></a>
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


@include('admin.footer')
