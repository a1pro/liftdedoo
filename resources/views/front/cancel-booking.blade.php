@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<style>
    label#email-error {
        width: 100%;
    }

</style>

<section class="contact mb-5">
    <div class="container login-main cancel-book">
        <div class="row">
            <h1 class="title text-center">Cancel Booking</h1>
            <div class="wrapper">
			<p class="mandatory">(<em>*</em>) mandatory fields</p>
                <div id="formContent">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session()->get('success') }}
                        </div>
                    @elseif(session()->has('cancel'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session()->get('cancel') }}
                        </div>
                    @endif
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('cancelBooking') }}">
                        @csrf
                        
                        <label class="label"><span>Booking Id</span><span
                                class="requard">*</span></label>
                        <input type="text" id="bookingId" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" class="input-text @error('email') is-invalid @enderror" name="bookingId" placeholder="" value="{{ old('email') }}" required required>
                      
                        <div class="actions">
                            <button type="submit" class="btn login-btn btn-primary show_confirm">{{ __('Cancel Booking') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">


  $('.show_confirm').click(function(event) {

        if($("#bookingId").val() != "")
        {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Do you want to cancel your booking?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
        }
    });
 
    $(".alert").fadeTo(2000, 2000).slideUp(2000, function() {
        $(".alert").slideUp(2000);
    });
  
</script>
  
@include('front.include.footer')
