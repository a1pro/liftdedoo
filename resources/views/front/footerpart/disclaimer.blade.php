@include('front.include.header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<section class="section cms-banner d-flex align-items-center">
    <div class="overlay"></div>
    <h1 class="title text-center">{{ isset($about->title) ? $about->title : "Disclaimer" }}</h1>
</section>
<section class="section cms-body position-relative py-3">
    <div class="container cms-container position-relative">
        <?php if(isset($about->description))
        {
             echo htmlspecialchars_decode($about->description);
        }
        else {
            echo "Disclaimer Description";
        }
      ?>
    </div>
    <section class="sticky">
        <div class="bubbles">
            <div class="bubble sky"></div>
            <div class="bubble"></div>
            <div class="bubble sky"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble red"></div>
            <div class="bubble red"></div>
            <div class="bubble"></div>
            <div class="bubble sky"></div>
            <div class="bubble"></div>

        </div>
    </section>
</section>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('front/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8">
</script>
@include('front.include.footer')
