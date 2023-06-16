{{--  <!-- Topbar Navbar -->  --}}

    <ul class="navbar-nav ml-auto">
        {{--  <!-- Nav Item - Alerts -->  --}}
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw" style="color: #fff;"></i>
                {{--  <!-- Counter - Alerts -->  --}}
                <span class="badge badge-danger badge-counter" id="notif_count"></span>
            </a>
            {{--  <!-- Dropdown - Alerts -->  --}}
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header rounded mt-0 bg-warning text-white">
                    Notification Center
                </h6>
                <div id="notif_list">
                </div>
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('notification') }}">Show All
                    Notification</a>
            </div>
        </li>

        {{--  <!-- Nav Item - Messages -->  --}}
        <li class="nav-item mx-1">
            <a class="nav-link" href="{{ route('admin-chat') }}" id="messagesDropdown">
                <i class="fas fa-envelope fa-fw" style="color: #fff"></i>
                {{--  <!-- Counter - Messages -->  --}}
                <span class="badge badge-danger badge-counter" id="message_count"></span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        {{--  <!-- Nav Item - User Information -->  --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile mr-2 rounded-circle" src="{{ url('../dashboard/img/undraw_profile.svg') }}">
                <span class="mr-2 d-none d-lg-inline text-white small font-weight-bold">{{ Auth::user()->username }}</span>
            </a>
            {{--  <!-- Dropdown - User Information -->  --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.admin') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>

            </div>
        </li>

    </ul>

</nav>
{{--  <!-- End of Topbar -->  --}}
