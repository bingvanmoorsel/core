<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @section('header')
        @section('title')
            <title>Victory</title>
        @show

        @section('meta')
            <meta charset="UTF-8">
            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        @show

        @section('style')
            <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="/css/backend.css">
        @show
    @show
</head>
<body>
@section('body')
    @include('victory.core::layout.partials.menu')

    <div class="victory__content-wrapper">
        test
        @yield('content')
    </div>

    @include('victory.core::layout.partials.header')
@show

@section('javascript')
@show
</body>
</html>