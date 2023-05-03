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
                    <h3 class="mb-1 font-weight-bold">Edit Right contact</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{url('home')}}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('right-contact')}}">
                                Right Content List
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Right contact</li>
                    </ol>
                </div>
                <a href="{{ url('right-contact') }}">
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
                             @if(session()->has('update'))
                                 <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                     {{ session()->get('update') }}
                                </div>
                            @endif
                            </div>
                            <div class="card-body">
                                <form id="edit" class="needs-validation" method="POST" action="{{url('update-right-contact')}}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="validation-fname">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Address" value="{{$contact_right->address}}" name="address" >
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Mobile" value="{{$contact_right->mobile}}" name="mobile" >
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Email</label>
                                        <input type="text" class="form-control" id="email" onkeyup="primaryEmail(this.value)" placeholder="Email" value="{{$contact_right->email}}" name="email" >
                                         <span style="color: red;" id="primaryEmailError"></span>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $contact_right->id }}" />
                                    <button class="btn btn-primary" id="hidebtn" type="submit">Submit</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
<script>
   $(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});
function primaryEmail(primaryemail){
        var email = primaryemail;
       // console.log(email);
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if ( !emailReg.test( email ) ) {
          $("#primaryEmailError").text('Please enter valid email');
           $("#hidebtn").attr("disabled",true);
        } else {
          $("#primaryEmailError").text('');
            $("#hidebtn").removeAttr("disabled");
        }
      }
    jQuery('#edit').validate({
        rules: {
            address: {
                required: true,
            },
            mobile:{
                required:true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,

            },

        },
        messages: {
            address: {
                required: "Please Enter Address",

            },
            mobile:{
                required: "Please Enter Your Mobile Number",
                number: "Please Enter Only Number",
                minlength: "Please Enter Mobile Number Not More then 10 Digits",
                maxlength: "Please Enter Mobile Number Not More then 10 Digits"
            },
            email: {
                required: "Please enter email",

            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
