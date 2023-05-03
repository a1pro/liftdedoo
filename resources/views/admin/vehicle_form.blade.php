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
                    <h3 class="mb-1 font-weight-bold">Vehicle Form</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('vehicle') }}">
                                VehicleTable
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Vehicle Form</li>
                    </ol>
                </div>
                <a href="{{ url('vehicle') }}">
            <h3 class="mb-1 font-weight-bold"><u>Back</u></h3>
            </a>
            </div>
        </div>
        <!-- page content -->
        <div class="page-content-wrapper mt--45">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <form id="vehicle" class="needs-validation" method="POST"
                                    action="{{ url('add_vehicle') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="validation-fname">Vehicle name</label>
                                        <input type="text" class="form-control" id="vehicle_name"
                                            placeholder="Vehicle Name" name="vehicle_name" value="{{ $vehicle_name }}"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Seat Capacity</label>
                                        <input type="text" class="form-control" id="seat_capacity"
                                            placeholder="Seat Capacity" name="seat_capacity" value="{{$seat_capacity}}" required>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $id }}" />
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    jQuery('#vehicle').validate({
        rules: {
            vehicle_name: {
                required: true,
            },

        },
        messages: {
            vehicle_name: {
                required: "Please Enter Vehicle Name",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
