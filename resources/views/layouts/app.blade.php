<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Servicein">
    <meta name="author" content="Servicein">

    <title>@yield('title')</title>
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
                    @include('includes.adminDashboard.navbar')
                {{--  <!-- Begin Page Content -->  --}}
                <div class="container-fluid">
                    <div class="row">
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
