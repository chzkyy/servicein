{{--  <!-- Sidebar -->  --}}
<ul class="navbar-nav sidebar-bg sidebar sidebar-dark accordion" id="accordionSidebar">

    {{--  <!-- Sidebar - Brand -->  --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-text mx-3">
            <img src="{{ url('assets/img/Logo.png') }}" alt="logo">
        </div>
    </a>

    {{--  <!-- Divider -->  --}}
    <hr class="sidebar-divider my-0">

    {{--  <!-- Nav Item - Dashboard -->  --}}
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __("Dashboard") }}</span></a>
    </li>

    {{--  <!-- Divider -->  --}}
    {{--  <hr class="sidebar-divider">  --}}

    {{--  <!-- Nav Item - Dashboard -->  --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile.admin') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __("Profile") }}</span></a>
    </li>

    {{--  <hr class="sidebar-divider">  --}}

    {{--  <!-- Nav Item - Dashboard -->  --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>{{ __("Bill") }}</span></a>
    </li>
</ul>
{{--  <!-- End of Sidebar -->  --}}
