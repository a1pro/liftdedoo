@include('admin.header')
<!-- Header End -->
<!-- Header End -->
<!-- Begin Left Navigation -->
<!-- Begin Left Navigation -->
@include('admin.sidebar')
<!-- Left Navigation End -->
<!-- Left Navigation End -->
<!-- Begin main content -->
<div class="main-content">
    <!-- content -->
    <div class="page-content">
        <!-- page header -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="page-title dflex-between-center">
                    <h3 class="mb-1 font-weight-bold">CMS Pages List Table</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('cms-pages-list')}}">
                                CMS Pages List
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
                                @if(session()->has('status'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session()->get('status') }}
                                    </div>
                                    @endif
                                <table id="scroll-horizontal-datatable" class="table ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Page Name</th>
                                            <th>Page Slug</th>
                                            <th>Title</th>
                                            <th>Meta Keywords</th>
                                            <th>Meta Description</th>
                                            <th>Meta Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        @foreach ($cms as $cms_page)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $cms_page->page_name }}</td>
                                                <td>{{ $cms_page->page_slug }}</td>
                                                <td>{{ $cms_page->title }}</td>
                                                <td>{{ $cms_page->keywords }}</td>
                                                <td>{{ $cms_page->meta_description }}</td>
                                                <td>{{ $cms_page->meta_title }}</td>
                                                <td style="text-align: center"><a href="{{ url('edit-cms-page') }}/{{ $cms_page->id }}"><button type="button" class="btn btn-warning waves-effect waves-light" data-effect="wave"><i class="fe-edit"></i></button></a></td>
                                            </tr>
                                            <?php $i++;?>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"></script>
<script>
   $(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});
</script>
<!-- main content End -->
@include('admin.footer')
