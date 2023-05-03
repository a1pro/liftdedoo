@include('app-admin.header')
<!-- Header End -->
<!-- Header End -->
<!-- Begin Left Navigation -->
<!-- Begin Left Navigation -->
@include('app-admin.sidebar')
<!-- Left Navigation End -->
<!-- Left Navigation End -->
<!-- Begin main content -->

<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 100; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
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
                                             <div class="form-group">
                                                <label for="example-password">State</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $users->state }}" class="form-control" value="password">
                                            </div>
                                             

                                            <div class="form-group">
                                                <label for="example-password">Profile Photo</label><br>
                                                <!-- <input type="text" id="example-password" readonly
                                                    value="{{ $users->license_number }}" class="form-control"
                                                    value="password"> -->
                                                    <img src="{{url('/') }}/storage/Vehicle/{{$users->profile_image}}" onclick="openmodal('profile')" id="profile" style="width:50px;height:50px;" alt="hdvgh">
                                            </div>
                                            <div class="form-group">
                                                Profile Status : <b>@if ($users->profile_verification_status == 1)
                                                                approved
                                                                @else
                                                                pending
                                                                <br>
                                                                <a href="{{url('/')}}/admin/app/driver/approve-profile/{{$users->id}}" class="btn btn-success">Approve Profile</a>

                                                @endif</b><br>
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
                                            <div class="form-group">
                                                <label for="example-password">City</label>
                                                <input type="text" id="example-password" readonly
                                                    value="{{ $users->city }}" class="form-control" value="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-password">License Photo</label><br>
                                                <!-- <input type="text" id="example-password" readonly
                                                    value="{{ $users->license_number }}" class="form-control"
                                                    value="password"> -->
                                                    <img src="{{url('/') }}/storage/Vehicle/{{$users->license_doc}}" onclick="openmodal('lisenceimg')" id="lisenceimg" style="width:50px;height:50px;" alt="hdvgh">
                                            </div>
                                            <div class="form-group">
                                                status : <b>

                                                @if ($users->document_verification_status == 1)
                                                                approved
                                                                @else
                                                                pending

                                                                <br>
                                          <a href="{{url('/')}}/admin/app/driver/approve-docs/{{$users->id}}" class="btn btn-success">Approve Documentation</a>
                                               <!--<a href="/admin/app/driver/approve-docs/{{$users->id}}" class="btn btn-success">Approve Documentation</a>-->
                                                @endif

                                                </b><br>
                             
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
                                                                <th>RC Copy</th>
                                                                <th>Verification Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            @foreach ($vehicles as $vehicle)
                                                            <br>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $vehicle->vehicle_name }}</td>
                                                                    <td>{{ $vehicle->vehicle_registration_number }}</td>
                                                                    <td>{{ $vehicle->capacity }}</td>
                                                                    <td>{{ $vehicle->rate_per_km }}</td>
                                                                       <td>
                                                                 <img src="{{url('/') }}/storage/Vehicle/{{$vehicle->rc_copy}}" onclick="openmodal('rcimage')" id="rcimage" style="width:50px;height:50px;" alt="hdvgh">
                                                                    </td>
                                                                    
                                                                 <!--   <td>-->
                                                                 <!--<img src="{{url('/') }}/storage/Vehicle/{{$vehicle->rc_copy}}" onclick="openmodal('rcimage')" id="rcimage" style="width:50px;height:50px;" alt="hgfff">-->
                                                                 <!--   </td>-->
                                                                    <td> <b>@if ($vehicle->verification_status == 1)
                                                                            Approved
                                                                            @else
                                                                            Pending
                                                             <a href="{{url('/')}}/admin/app/driver/approve-vehicle/{{$vehicle->id}}" class="btn btn-success">Approve vehicle</a>

                                                                    @endif
                                                                    </b></td>
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

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
<script>

    function openmodal(id)
    {
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById(id);
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
  modal.style.display = "block";
  modalImg.src = img.src;
  captionText.innerHTML = this.alt;

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
    }

</script>

<!-- main content End -->
@include('app-admin.footer')
