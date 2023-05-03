<aside class="side-navbar">
    <div class="scroll-content" id="metismenu">
        <ul id="side-menu" class="metismenu list-unstyled">
            <li class="side-nav-title side-nav-item menu-title">Menu</li>
            <li>
                <a href="{{ url('/home') }}" class="side-nav-link" aria-expanded="false">
                    <i class="bx bx-home-circle"></i>
                    <span> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('location') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-location-pin"></i>
                    <span> Location</span>
                </a>
            </li>
            <li>
                <a href="{{ url('vehicle') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span> Vehicle Type</span>
                </a>
            </li>
          
        
            {{-- <li>
                <a href="{{url('driver-availability')}}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span>Driver Availability Booking List</span>
                </a>
            </li>
            <li>
                <a href="" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span>Agency Availability Booking List</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ url('cms-pages-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="mdi mdi-note-text-outline"></i>
                    <span> CMS Pages</span>
                </a>
            </li>
            <li>
                <a href="{{ url('contactus') }}" class="side-nav-link" aria-expanded="false">
                    <i class="bx bxs-user-detail"></i>
                    <span> Contact Us</span>
                </a>
            </li>
            <li>
                <a href="{{ url('right-contact') }}" class="side-nav-link" aria-expanded="false">
                    <i class="bx bxs-user-detail"></i>
                    <span>Right Contact Us Section</span>
                </a>
            </li>
            <li>
                <a href="{{ url('users-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span> Users List</span>
                </a>
            </li>
            <li>
                <a href="{{ url('inquiry-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-envelope"></i>
                    <span> Inquiry List</span>
                </a>
            </li>
            <li>
                <a href="{{ url('search-users-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span> Search Users List</span>
                </a>
            </li>
            <li>
                <a href="{{ url('driver-availability-booking-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span>New Availability List</span>
                </a>
            </li>
            <li>
                <a href="{{ url('booking-requests/0') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>New Booking Request <span style="color:red"> ({{Helper::getNewRequestCount()}})</span></span>
                </a>
            </li>

            <li>
                <a href="{{ url('booking-requests/1') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Confirmed Booking </span>
                </a>
            </li>

            <li>
                <a href="{{ url('booking-requests/2') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Cancel Booking Request</span>
                </a>
            </li>

            <li>
                <a href="{{ url('customer-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Registered Customer List</span>
                </a>
            </li>
              <li>
                <a href="{{ url('driver-availability-booking-list') }}" class="side-nav-link" aria-expanded="false">
                    <i class="icon-people"></i>
                    <span>New Availability List</span>
                </a>
            </li>
            
            
            
            {{-- <li>
                <a href="{{ url('paytm-details') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Paytm Details</span>
                </a>
            </li> --}}

            <li>
                <a href="{{url('paytm-payment')}}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Paytm Payment</span>
                </a>
            </li>
            
            
            <li>
                <a href="{{ url('payment-pending') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Pending Payment List</span>
                </a>
            </li>

            <li>
                <a href="{{ url('paytm-details') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>Paytm Details</span>
                </a>
            </li>
            <li>
                <a href="{{ url('app/drivers') }}" class="side-nav-link" aria-expanded="false">
                    <i class="fe-truck"></i>
                    <span>App Dashboard</span>
                </a>
            </li>
            
        </ul>
    </div>
</aside>
