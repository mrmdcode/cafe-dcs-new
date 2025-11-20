<!DOCTYPE html>
<html lang="fa">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="HTML5,CSS3,HTML,Template,multi-page,Farol - Bootstrap 5 Admin Dashboard Template" >
    <meta name="description" content="">
    <meta name="author" content="MrMDCode">
    <meta name="x-csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{env('APP_URL')}}">


    @include('Layouts._partial._css')
    @yield('css')

    <title>@yield('title')</title>
</head>
<body>

<div class="preloader" id="preloader">
    <div class="preloader">
        <div class="waviy position-relative">
            <span class="d-inline-block">M</span>
            <span class="d-inline-block">r</span>
            <span class="d-inline-block">M</span>
            <span class="d-inline-block">D</span>
            <span class="d-inline-block">C</span>
            <span class="d-inline-block">o</span>
            <span class="d-inline-block">d</span>
            <span class="d-inline-block">e</span>
        </div>
    </div>
</div>


        @yield('aside_menu')


<div class="container-fluid">
    <div class="main-content d-flex flex-column @if(!\Illuminate\Support\Facades\Auth::check()) px-0 @endif">

        @yield('top_menu')

       @yield('content')

        <div class="flex-grow-1"></div>
        <footer class="footer-area bg-white text-center rounded-top-10" dir="ltr">
            <p class="fs-14">© <span class="text-primary">Digital Coffee</span> Created by <a href="https://mrmdcode.ir" class="text-primary">MrMDCode</a></p>
        </footer>

    </div>
</div>




@include('Layouts._partial._js')
@yield('js')
</body>
</html>
