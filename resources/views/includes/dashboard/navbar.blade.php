{{--  navbar  --}}]
<nav class="navbar navbar-expand-lg navbar-bg">
    <div class="container-fluid">
        <a class="navbar-brand mx-5" href="#">
            <img src="{{ url('assets/img/Logo.png') }}" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav col-md-11">
                <li class="nav-item col-md-8 my-auto mx-auto">
                    <form role="search">
                        <div class="custom-search">
                            <input type="text" class="custom-search-input" placeholder="Search">
                            <button class="custom-search-botton" type="submit">Search</button>
                        </div>
                    </form>
                </li>

                <li class="nav-item my-auto">
                    <a href="#" class="nav-link cart text-white text-decoration-none">
                        <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                        <span class="cart-number">0</span>
                    </a>
                </li>

                <li class="nav-item my-auto mx-1">
                    <a href="#" class="nav-link chat text-white text-decoration-none">
                        <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                        <span class="chat-number">0</span>
                    </a>
                </li>

                <li class="nav-item my-auto mx-1">
                    <a href="#" class="nav-link notif text-white text-decoration-none">
                        <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
                        <span class="notif-number">0</span>
                    </a>
                </li>

                <div class="vr mx-1 my-auto"></div>

                @guest
                    <li class="nav-item dropdown">
                        <a href="{{ route('login') }}" class="nav-link">
                            {{--  profile image with text  --}}
                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                            <span class="mx-2 fw-semibold">Login / Sign Up</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                            <span class="mx-2 fw-semibold">{{ Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
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
