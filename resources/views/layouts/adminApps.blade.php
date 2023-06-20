<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Servicein">
    <meta name="author" content="Servicein">

    <title>@yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link href="{{ url('dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/css/custome.css') }}" rel="stylesheet">

    {{--  @include('includes.adminDashboard.style')  --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/kt-2.9.0/r-2.4.1/sc-2.1.1/sl-1.6.2/datatables.min.css" rel="stylesheet"/>

    @include('includes.dashboard.style')

</head>

<body id="page-top">

    {{--  <!-- Page Wrapper -->  --}}
    <div id="wrapper">
        {{--  <!-- Content Wrapper -->  --}}
        <div id="content-wrapper" class="d-flex flex-column">
            {{--  <!-- Main Content -->  --}}
            <div id="content">
                {{--  <!-- Topbar -->  --}}
            <nav class="navbar navbar-expand navbar-bg bg-white topbar mb-4 static-top shadow">
                <div class="container-fluid">
                    <a class="navbar-brand mx-5" href="{{ route('home') }}">
                        <img src="{{ url('assets/img/Logo.png') }}" alt="logo">
                    </a>
                </div>
                {{--  <!-- Topbar Navbar -->  --}}

                <ul class="navbar-nav ml-auto">

                    {{--  <!-- Nav Item - User Information -->  --}}
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile mr-2 rounded-circle" src="{{ url('../dashboard/img/undraw_profile.svg') }}">
                            <span class="mr-2 d-none d-lg-inline text-white small font-weight-bold">{{ Auth::user()->username }}</span>
                        </a>
                        {{--  <!-- Dropdown - User Information -->  --}}
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>

                        </div>
                    </li>

                </ul>

            </nav>
            {{--  <!-- End of Topbar -->  --}}
                @yield('content')

            </div>
            {{--  <!-- End of Main Content -->  --}}

        </div>
        {{--  <!-- End of Content Wrapper -->  --}}

    </div>
    {{--  <!-- End of Page Wrapper -->  --}}

    {{--  <!-- Scroll to Top Button-->  --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('includes.adminDashboard.modal.logout')
    @include('includes.dashboard.footer')
    @include('includes.dashboard.script')
    @yield('additional-script')



    <script src="{{ url('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{--  <!-- Core plugin JavaScript-->  --}}
    <script src="{{ url('dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    {{--  <!-- Custom scripts for all pages-->  --}}
    <script src="{{ url('dashboard/js/sb-admin-2.min.js') }}"></script>

    {{--  @include('includes.adminDashboard.script')  --}}
</body>

</html>
