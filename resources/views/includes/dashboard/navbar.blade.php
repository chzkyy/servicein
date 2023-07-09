{{--  navbar  --}}
<nav class="navbar fixed-top navbar-expand-lg navbar-bg">
    <div class="container-fluid">
        <a class="navbar-brand mx-2" href="{{ route('home') }}">
            <img src="{{ url('assets/img/Logo.png') }}" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav col-md-12 d-flex justify-content-end">

                @guest
                    <li class="nav-item col-md-6 my-4 my-md-1 mx-auto mb-4 mb-md-0">

                        <div class="custom-search">
                            <form action="{{ route('search-merchant') }}" method="get" id="search_merchant">
                                <input type="text" class="custom-search-input" id="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                <input type="hidden" name="origin" id="origin">
                                <button class="custom-search-botton" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </li>
                @elseif( Auth::user()->role != 'Admin' )
                    <li class="nav-item col-md-6 my-4 my-md-1 mx-auto mb-4 mb-md-0">
                        <div class="custom-search">
                            <form action="{{ route('search-merchant') }}" method="get" id="search_merchant">

                                <input type="text" class="custom-search-input" id="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                <input type="hidden" name="origin" id="origin">
                                <button class="custom-search-botton" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </li>

                @endguest

                {{--  notification  --}}
                {{--  notification   --}}
                <li class="nav-item dropdown my-auto mx-1">

                    {{--  create icon with badge  --}}
                    <a class="nav-link" id="notificationDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{--  badge count in desktop view and hide in mobile --}}
                        <span class="d-none badge bg-danger position-absolute top-0 start-50 badge-counter badge-pill" id="notif_count"></span>
                        <i class="fas fa-bell fa-fw" style="color: #fff"></i>
                        {{--  badge count in mobile view and hide in desktop --}}
                        <span class="d-md-none position-absolute badge bg-danger ms-2 fw-semibold text-white start-0 top-0 badge-pill badge-counter" id="notif_mobile"></span>
                        <span class="d-md-none ms-2 fw-semibold text-white">Notification</span>
                    </a>


                    <ul class="dropdown-menu dropdown-menu-end mt-3 dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationDropdown">
                        <li><h6 class="dropdown-header text-white border border-1 border-dark rounded bg-warning fw-semibold">NOTIFICATION CENTER</h6></li>

                        <li id="notif_list" class="text-center small text-gray-500"></li>
                        @guest
                            <li class="text-center small text-gray-500">{{ __("No Notification") }}</li>
                        @else
                            <li>
                                <a class="dropdown-item text-center small mb-n3 text-gray-600" href="{{ route('notification') }}">Show All Notification</a>
                            </li>
                        @endguest
                        {{--  button see all message  --}}
                    </ul>
                </li>

                {{--  chat notification  --}}
                <li class="nav-item my-auto mx-1">
                    <a class="nav-link" id="messagesDropdown" href="{{ route('chat') }}" >
                        {{--  badge count in desktop view and hide in mobile --}}
                        <span class="d-none badge bg-danger position-absolute top-0 my-3 ms-2 badge-counter badge-pill" id="chat_dstp"></span>
                        <i class="fas fa-envelope fa-fw" style="color: #fff"></i>
                        {{--  badge count in mobile view and hide in desktop --}}
                        <span class="d-md-none ms-2 fw-semibold text-white">Messages</span>
                        <span class="d-md-none position-absolute badge bg-danger top-50 start-0 mt-5 fw-semibold text-white badge-pill badge-counter" id="chat_mobile" style="margin-left: 2.2rem !important"></span>
                    </a>
                </li>

                <div class="vr mx-1 my-auto d-none d-md-block"></div>

                @guest
                    <li class="nav-item dropdown">
                        <a href="{{ route('login') }}" class="nav-link">
                            {{--  profile image with text  --}}
                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                            <span class="mx-2 fw-semibold text-white">Login / Sign Up</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown ">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{--  if avatar != null  --}}
                            @if ( Auth::user()->avatar != null )
                                <img class="img-profile" src="{{ url(Auth::user()->avatar) }}" alt="Avatar" class="img-fluid">
                            @else
                                <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                            @endif
                            <span class="mx-2 fw-semibold text-white">{{ Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu mt-3 dropdown-menu-end">
                            <li>
                                @if ( Auth::user()->role == 'Admin' )
                                    <a class="dropdown-item" href="{{ route('profile.admin') }}">Profile</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                @endif
                            </li>
                            <li>
                                @if ( Auth::user()->role == 'User' )
                                    <a class="dropdown-item" href="{{ route('show-transaction') }}">Transaction List</a>
                                @endif
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('faq') }}">FAQ</a>
                            </li>
                            <hr>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
