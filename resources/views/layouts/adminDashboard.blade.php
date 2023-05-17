<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Servicein">
    <meta name="author" content="Servicein">
    <title>@yield('title')</title>
    @include('includes.dashboard.style')
</head>

<body>
    @include('includes.dashboard.navbar')
    @yield('content')
    @include('includes.adminDashboard.script')
</body>

</html>
