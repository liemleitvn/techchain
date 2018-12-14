<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TechChain Software</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('front-end/css/style.css')}}">
</head>
<body>
    <!--Header-->
    @include('layouts.front-end.layouts.header')
    
    <!--Content-->
    @yield('content')

    @include('layouts.front-end.layouts.last')
</body>
</html>