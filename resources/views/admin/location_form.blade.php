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
                    <h3 class="mb-1 font-weight-bold">Location Form</h3></br>

                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('location') }}">
                                location
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Location Form</li>
                    </ol>
                </div>
                <a href="{{ url('location') }}">
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
                                <form id="location" class="needs-validation" method="POST"
                                    action="{{ url('add_location') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="validation-fname">Location name</label>
                                        <input type="text" class="form-control map-input" id="address-input" placeholder="Location name" name="location" value="{{ $location }}" required>
                                    </div>
                                    <div style="width: 100%; height: 100%" id="address-map"></div>
                                    <div class="form-group">
                                        <label for="validation-fname">Latitude</label>
                                        <input type="text" class="form-control" id="address-latitude" placeholder="Latitude" name="latitude" value="{{$latitude}}" required>
                                         {{-- <input type="hidden" class="form-control" id="address-latitude" placeholder="Latitude" name="latitude" value="0" required> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Longitude</label>
                                        <input type="text" class="form-control" id="address-longitude" placeholder="Longitude" name="longitude" value="{{$longitude}}" required>
                                        {{-- <input type="hidden" class="form-control" id="address-longitude" placeholder="Longitude" name="longitude" value="0" required> --}}
                                    </div>
                                    <input type="hidden" name="id" value="{{ $id }}" />
                                    <input type="hidden" name="lati" id="lati" value="{{ $id }}" />
                                    <input type="hidden" name="lng" id="lng" value="{{ $id }}" />
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
{{-- javascript code --}}
{{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script> --}}
{{-- <script src="{{ asset('admin/js/mapInput.js')}}"></script> --}}
<script>
    //  $('form').on('keyup keypress', function(e) {
    //     var keyCode = e.keyCode || e.which;
    //     if (keyCode === 13) {
    //         e.preventDefault();
    //         return false;
    //     }
    // });


    jQuery('#location').validate({
        rules: {
            location: {
                required: true,
            },

        },
        messages: {
            location: {
                required: "Please Enter Location",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
