<aside class="side-navbar">
    <div class="scroll-content" id="metismenu">
        <ul id="side-menu" class="metismenu list-unstyled">
            <li class="side-nav-title side-nav-item menu-title">APP Menu</li>
            <li>
                <a href="{{ url('/home') }}" class="side-nav-link" aria-expanded="false">
                    <i class="bx bx-home-circle"></i>
                    <span> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{url('app/drivers')}}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-location-pin"></i>
                    <span> Drivers</span>
                </a>
            </li>
            <li>
                <a href="{{url('/admin/app/driver-policy')}}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-location-pin"></i>
                    <span> Driver Policy</span>
                </a>
            </li>
            <li>
                <a href="{{url('/admin/app/blockeduser')}}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-location-pin"></i>
                    <span> Blocked User</span>
                </a>
            </li>
            <li>
                <a href="{{ url('vehicle') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span> Web Dash</span>
                </a>
            </li>
          
   
            
        </ul>
    </div>
</aside>
