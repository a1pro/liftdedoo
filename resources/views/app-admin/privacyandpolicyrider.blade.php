@include('app-admin.header')
<!-- Header End -->
<!-- Header End -->
<!-- Begin Left Navigation -->
<!-- Begin Left Navigation -->
@include('app-admin.sidebar')
<div class="main-content">
    <!-- content -->
    <div class="page-content">
    <form action="/admin/updatepolicy" method="post">
        @csrf
        <input type="submit" value="submit" class="btn btn-primary mt-5">

        <input type="hidden" name="id" value="{{$policy->id}}">
    <textarea class="form-control" id="policy" placeholder="Enter the Description" name="policy"></textarea>
    <input type="submit" value="submit" class="btn btn-primary">
    </form>
</div>
</div>

                  
                    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
                    <script>
//                         ClassicEditor.create('#body', {
//   // filebrowserBrowseUrl: '/browser/browse.php',
//   //   filebrowserUploadUrl: '/uploader/upload.php',
//   // filebrowserBrowseUrl: '/apps/ckfinder/3.4.5/ckfinder.html',
//     // filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
//     // filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
//     //     customConfig: '/ckeditor/config.js'

// });
let myEditor;
ClassicEditor
.create( document.querySelector( '#policy' ) )
.then(editor => {
            window.editor = editor;
            myEditor = editor;
            setContent();
        })
.catch( error => {
console.error( error );

} );
function setContent()
{
   <?php 
   $data = $policy->policy;
//    $data = preg_replace('/(<br(|\s*\/)>)/', "\n", $data);
   $data = str_replace("\r\n","\\\r\n",$data);
   $data = str_replace("\n","\\\n",$data);
//    $data = str_replace("/'/g","\\'",$data);
   $data =  str_replace("'", "\'", $data);
   ?>
    let policy = '<?php echo $data; ?>';
    myEditor.setData(policy);

}
</script>
@include('app-admin.footer')
 