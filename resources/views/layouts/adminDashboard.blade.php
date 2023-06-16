<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Servicein">
    <meta name="author" content="Servicein">

    <title>{{ __("Merchant - Dashboard") }}</title>
    @include('includes.adminDashboard.style')

</head>

<body id="page-top">

    {{--  <!-- Page Wrapper -->  --}}
    <div id="wrapper">

        @include('includes.adminDashboard.sidebar')

        {{--  <!-- Content Wrapper -->  --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{--  <!-- Main Content -->  --}}
            <div id="content">
                {{--  <!-- Topbar -->  --}}
                <nav class="navbar navbar-expand navbar-bg bg-white topbar mb-4 static-top shadow">
                    {{--  <!-- Sidebar Toggle (Topbar) -->  --}}
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    @include('includes.adminDashboard.navbar')

                {{--  <!-- Begin Page Content -->  --}}
                <div class="container-fluid">

                    {{--  <!-- Page Heading -->  --}}
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    {{--  <!-- Content Row -->  --}}
                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-primary text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="title text-center">{{ __('Booked') }}</div>
                                    <h3 class="count_booked text-center font-weight-bold">{{ $status_booked}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-warning text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="title text-center">{{ __('On Progress') }}</div>
                                    <h3 class="count_booked text-center font-weight-bold">{{ $status_process }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-success text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="title text-center">{{ __('Done') }}</div>
                                    <h3 class="count_booked text-center font-weight-bold">{{ $status_done }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card bg-danger text-white shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="title text-center">{{ __('Cancelled') }}</div>
                                    <h3 class="count_booked text-center font-weight-bold">{{ $status_cancel }}</h3>
                                </div>
                            </div>
                        </div>

                        @yield('content')
                    </div>

                </div>
                {{--  <!-- /.container-fluid -->  --}}

            </div>
            {{--  <!-- End of Main Content -->  --}}

            @include('includes.adminDashboard.footer')

        </div>
        {{--  <!-- End of Content Wrapper -->  --}}

    </div>
    {{--  <!-- End of Page Wrapper -->  --}}

    {{--  <!-- Scroll to Top Button-->  --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('includes.adminDashboard.modal.logout')

    @include('includes.adminDashboard.script')
    @yield('additional-script')

</body>

</html>
