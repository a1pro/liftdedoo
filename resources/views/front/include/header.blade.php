<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="{{ isset($about->meta_description) ? $about->meta_description : 'Default description.' }}">
    <meta name="keywords" content="{{ isset($about->keywords) ? $about->keywords : 'Default description.' }}">
    <meta name="title" content="{{ isset($about->meta_title) ? $about->meta_title : 'Default description.' }}">
    <title>LiftDedoo.com - Cheapest fare ever</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;0,700;1,400&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/slick.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/images/favicon-16x16.png') }}">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('admin/css/icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style-comon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    <script src="{{ asset('front/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('front/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">




</head>

<body class="cms-page">
    <div id="pageloader" style="display:none"><div class="loader-item  colored-border">Please Wait.....</div></div>
    <header class="header">
        <div class="container-fluid relative">
            <div class="absolute-text-sec">
                <div class="container h-100">
                    <div class="row">
					 <div class="col-md-2 responsive-menu">
					 <button class="navbar-btn" onClick="openNav3('navmain', 'overclse')"><span class="navbar-toggler-icon"></span></button>					   
					 </div>
                        <div class="col-6 col-md-3 logo-sec">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('front/images/logo-new.png') }}"
                                        alt="liftdedoo.com" /></a>
                            </div>
                        </div>
						<div id="overclse" class="over2" onClick="closeNav3('overclse')"></div>
                        <div class="col-4 col-md-9 header-right d-flex h-100 align-items-center">
                            <nav id="navmain" class="navbar navbar-expand-lg">
                               <a href="javascript:void(0)" class="closebtn-menu" onClick="closeNav3('navmain', 'overclse')">&times;</a>
                                <div class="nav-bdy">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::segment(1) ==  'about-us' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'about-us' ? 'color:#f42e00' : ''  }} " href="{{ url('about-us') }}">About Us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::segment(1) ==  'contact-us' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'contact-us' ? 'color:#f42e00' : ''  }} " href="{{ url('contact-us') }}">Contact Us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Request::segment(1) ==  'how-its-work' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'how-its-work' ? 'color:#f42e00' : ''  }} " href="{{ url('how-its-work') }}">How it's Work</a>
                                        </li>
                                        <li class="nav-item">
                                        
                                        <!-- <li class="nav-item">
                                            <a  class="nav-link {{ Request::segment(1) ==  'mission-vission' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'mission-vission' ? 'color:#f42e00' : ''  }}" href="{{ url('mission-vission') }}">Mission
                                                &amp;
                                                Vission</a>
                                        </li> -->
                                        <li class="nav-item desk-link">
                                            <a  class="nav-link enquiry-form position-relative"  href="javascript:void(0);">Book Your Enquiry <span class="new">New</span></a>
                                        </li>
                                        
                                        <li class="nav-item res-link">
                                        <a href="{{ url('admin/login') }}"
                                            class="nav-link">Admin Login</a>
										</li>
										
										<li class="nav-item res-link">
										<a href="{{ url('driver-registration') }}" class="nav-link">Driver
                                            Registration</a>
										</li>
										
										<li class="nav-item res-link">
                                        <a href="{{ url('travel-agency-registration') }}"
                                            class="nav-link">Travel Agencies Registration</a>
										</li>
										<li class="nav-item cancel res-link"><a class="nav-link {{ Request::segment(1) ==  'data-protection' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'cancel-booking' ? 'color:#f42e00' : ''  }} " href="{{ url('cancel-booking') }}">Cancel Booking</a></li>
                                    </ul>
                                </div>
                            </nav>
							<div class="booking-req res-link" ><a class="enquiry-form position-relative" href="javascript:void(0);"><span class="pls">+</span>Enquiry</a></div>
							<div class="booking-en desk-link" ><img src="{{ asset('front/images/booking-inq.png') }}" alt="" /><span>1800-891-1324</span></div>
                            <div class="user-container btn-group">
                                @if (!empty(Auth::user()))
                                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                                        <button type="button" class="btn user btn-secondary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            {{ Auth::user()->name }}
                                        </button>
                                    @elseif (Auth::user()->role == 0)
                                    <script>window.location = "{{ route('adminHomePage') }}";</script>
                                    <button type="button" class="btn user btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" onClick="return alert('Already login as admin, please logout from admin first')" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </button>

                                    @endif
                                @else
                                    <button type="button" class="btn user btn-secondary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </button>
                                @endif
                                @if (!empty(Auth::user()))
                                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item {{ Request::segment(1) ==  'my-account' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'my-account' ? 'color:#f42e00' : ''  }} " href="{{ route('my_account') }}" >My Account</a>
                                            <a class="dropdown-item {{ Request::segment(1) ==  'change-password' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'change-password' ? 'color:#f42e00' : ''  }} " href="{{ url('change-password') }}">Change Password</a>
                                            <a href="{{ route('logout') }}" class="dropdown-item"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    @endif
                                @else
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ url('login') }}" class="dropdown-item">Login</a>
                                         <a href="{{ url('admin/login') }}" class="dropdown-item">Admin Login</a>
                                        <a href="{{ url('driver-registration') }}" class="dropdown-item res-hide">Driver
                                            Registration</a>
                                        <a href="{{ url('travel-agency-registration') }}"
                                            class="dropdown-item res-hide">Travel Agencies Registration</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<script>
function openNav3() {
  document.getElementById("navmain").style.width = "65%";
  document.getElementById("overclse").style.width = "35%";
}

function closeNav3() {
  document.getElementById("navmain").style.width = "0%";
  document.getElementById("overclse").style.width = "0%";
}
</script>
<script>
$(window).scroll(function(){
  var sticky = $('.header'),
      scroll = $(window).scrollTop();

  if (scroll >= 50) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
});
</script>
<script>
$(".user").click(function(){
  $("#navbarNavDropdown").removeClass("show");
});
</script>

<!-- <script>
    $(document).ready(function() {
        var url = window.location.href;
        url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
        url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
        url = url.substr(url.lastIndexOf("/") + 1);
        $('#navbarNavDropdown ul.navbar-nav li a').each(function(){
            // alert(url);
            var href =$('a').attr("href");
            href = href.substr(href.lastIndexOf("/") + 1);
            alert(href);
            if(url == href){
                $(this).addClass('current');
            }
            else
            {
                $(this).removeClass('current');
            }
        });
    });
</script> -->