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
                    <h3 class="mb-1 font-weight-bold">Edit CMS Page</h3>
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item">
                            <a href="{{ url('home') }}">
                                <i class="bx bx-home fs-xs"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{url('cms-pages-list')}}">
                                CMS Pages List
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit CMS Page</li>
                    </ol>
                </div>
                <a href="{{ route('cms-page-list') }}">
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
                                <form id="cmspage" class="needs-validation" method="POST"
                                    action="{{ url('update-cms-page') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="validation-fname">Page Name</label>
                                        <input type="text" class="form-control" id="page_name" placeholder="Page Name"
                                            value="{{ $pages->page_name }}" name="page_name" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Page Title</label>
                                        <input type="text" class="form-control" id="title" placeholder="Page Title"
                                            value="{{ $pages->title }}" name="title">
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Page Description</label>
                                        <div class="">
                                            <textarea id="page-description" name="description" rows="7"
                                                class="form-control ckeditor"
                                                placeholder="Write your message..">{{ $pages->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="validation-fname">Meta Keywords</label>
                                        <input type="text" class="form-control" id="keywords"
                                            placeholder="Meta Keywords" value="{{ $pages->keywords }}" name="keywords">
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Meta Descriptions</label>
                                        <input type="text" class="form-control" id="meta_description"
                                            placeholder="Meta Descriptions" value="{{ $pages->meta_description }}"
                                            name="meta_description">
                                    </div>

                                    <div class="form-group">
                                        <label for="validation-fname">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title"
                                            placeholder="Meta title" value="{{ $pages->meta_title }}" name="meta_title">
                                    </div>

                                    <input type="hidden" name="id" value="{{ $pages->id }}" />
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replace('page-description');



    });

    jQuery('#cmspage').validate({

        rules: {
            title: {
                required: true,
            },
            description: {
                required: true,
            },
            keywords: {
                required: true,
            },
            meta_description: {
                required: true,
            },
            meta_title: {
                required: true,
            }

        },
        messages: {
            title: {
                required: "Please Enter Page Title",
            },
            description: {
                required: "Please Enter Page Description",
            },
            keywords: {
                required: "Please Enter Keywords",
            },
            meta_description: {
                required: "Please Enter Meta Description",
            },
            meta_title: {
                required: "Please Enter Meta Title",
            },


        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<!-- main content End -->
@include('admin.footer')
