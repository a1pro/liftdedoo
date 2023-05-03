<div id="overclose" onclick="closeNav()"></div>
<div id="leftmenu" class="col-left sidebar overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <h2 class="title">Driver Dashboard</h2>
	<div class="overlay-content">
    <ul>
        <li><a class="{{ Request::segment(1) ==  'my-account' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'my-account' ? 'color:#f42e00' : ''  }}" href="{{ route('my_account') }}">My Account</a></li>
        <li><a class="{{ Request::segment(1) ==  'driver-car-info' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'driver-car-info' ? 'color:#f42e00' : ''  }}" href="{{ url('driver-car-info') }}" >My vehicle info</a></li>
        <li><a class="{{ Request::segment(1) ==  'driver-availability-booking' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'driver-availability-booking' ? 'color:#f42e00' : ''  }}" href="{{ url('driver-availability-booking') }}">Book My Availability</a></li>
        <li><a class="{{ Request::segment(1) ==  'driver-booking-history' ? 'current' : ''  }}" style="{{ Request::segment(1) ==  'driver-booking-history' ? 'color:#f42e00' : ''  }}"  href="{{ url('driver-booking-history') }}">My Booking History</a></li>
    </ul>
 </div>
</div>
<div class="left-fix-menu"><span class="left-switch" onclick="openNav()">Menu<i class="fa fa-angle-right" aria-hidden="true"></i></span></div>
<a class="back" href="{{ route('my_account') }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i>Back to Dashboard</a>
<script>
function openNav() {
  document.getElementById("leftmenu").style.width = "55%";
  document.getElementById("overclose").style.width = "45%";
}

function closeNav() {
  document.getElementById("leftmenu").style.width = "0%";
  document.getElementById("overclose").style.width = "0%";
}
</script>