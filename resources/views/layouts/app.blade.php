<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title>@yield('title', '思購易AR測試後台')</title>

    @include('layouts.style')
</head>
<body>
@include('layouts.header')
@if (Session::has('message'))
    <div class="alert alert-success col-md-10 col-md-offset-1" style="margin-right: 50px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('message') }}
    </div>
@endif

@yield('content')

@if(!(auth()->guest()))
    @include('vuforia.postTarget')
@endif

@include('layouts.script')
</body>
</html>
