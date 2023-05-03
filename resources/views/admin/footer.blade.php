<!-- footer -->
<!-- footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mb-1 mb-md-0">
                <span>2021 &copy; Liftdedoo</span>
            </div>
        </div>
    </div>
</footer>


</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Page End -->
<!-- ================== BEGIN BASE JS ================== -->
<script src="{{ asset('admin/js/vendor.min.js') }}"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="{{ asset('admin/libs/flatpicker/js/flatpickr.js') }}"></script>
{{-- <script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('admin/libs/chartjs/js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/utils/colors.js') }}"></script>
{{-- <script src="{{ asset('admin/js/pages/dashboard.init.js') }}"></script> --}}

<script src="{{ asset('admin/libs/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/buttons.bootstrap4.min.js')}}"></script>

<script src="{{ asset('admin/libs/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/buttons.print.min.js')}}"></script>

<script src="{{ asset('admin/libs/datatables/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/dataTables.select.min.js')}}"></script>

<script src="{{ asset('admin/libs/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('admin/libs/datatables/js/vfs_fonts.js')}}"></script>

<!-- ================== END PAGE LEVEL JS ================== -->
<!-- ================== BEGIN PAGE JS ================== -->
<script src="{{ asset('admin/js/pages/datatables.init.js')}}"></script>
<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ asset('admin/js/ckeditor4/ckeditor.js')}}"></script>
<script src="{{ asset('admin/js/ckeditor/js/ckeditor.min.js')}}"></script>
{{-- <script src="{{ asset('admin/js/pages/form-ckeditors.init.js')}}"></script> --}}
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = document.referrer;
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }
    
</script>

</body>

</html>
