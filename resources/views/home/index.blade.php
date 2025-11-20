<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
    <!-- TITLE-->
    <title>دیجیتال کافی شاپ</title>
    <!-- FAV ICON -->
    <link rel="shortcut icon" href="{{asset('assets/home/images/favicon.ico')}}" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="منوی آنلاین ،سفارشگیر ، کافه دیجیتال">
    <meta name="author" content="mrmdcode">
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/bootstrap.min.css')}}" type="text/css" />
    <!-- FONTAWESOME CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/font-awesome.min.css')}}" type="text/css" />
    <!-- OWL CAROUSEL CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/owl.carousel.min.css')}}" type="text/css" />
    <!-- ANIMATE CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/animate.min.css')}}" type="text/css" />
    <!-- LIGHTBOX CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/lightbox.min.css')}}" type="text/css" />
    <!-- YTPLAYER CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/mb.YTPlayer.min.css')}}" type="text/css" />
    <!-- FLATICON CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/flaticon.css')}}" type="text/css" />
    <!-- BOOTSTRAP VALIDATOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/validator.min.css')}}" type="text/css" />
    <!-- THEME STYLE CSS -->
    <link rel="stylesheet" href="{{asset('assets/home/css/style.css')}}" type="text/css" />
    <!-- Latest IE rendering engine & Chrome Frame Meta Tags -->
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <![endif]-->
</head>
<body data-spy="scroll" data-offset="62">

<!-- Page Loader -->
<div class="page-loader"></div>

<div class="main-wrap">

    <!-- Fixed Navbar -->
    <nav class="navbar navbar-sticky navbar-transparent">
        <!-- Navbar Transparent Class: navbar-transparent -->
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand primary-logo" href="#"><img class="img-responsive" src="{{asset('assets/home/images/logo-theme.png')}}" alt="Logo" /></a>
                <a class="navbar-brand sticky-logo" href="#"><img class="img-responsive" src="{{asset('assets/home/images/logo.png')}}" alt="Logo" /></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav pull-right">
                    <li class="active"><a href="#home">خانه</a></li>
                    <li><a href="#about">درباره ما</a></li>
                    <li><a href="#service">سرویس ها</a></li>
                    <li><a href="#plans">قیمت ها</a></li>
                    <li><a href="#contact">تماس با ما</a></li>
                    <li><a href="{{route('login')}}">ورود</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- Theme Header Start -->
    @include('home._partial._header')
    <!-- Theme Header End -->
    <!-- About Section -->
    @include('home._partial._about')
    <!-- Who we are -->
    @include('home._partial._about_2')

    <!-- About Section End-->
    <!-- Support Section Start -->
    @include('home._partial._support')
    <!-- Support Section End -->
    <!-- Service Section Start -->
    <section class="padding-bottom-50" id="service">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2 class="section-title-divider primary-divider">خدمات ما</h2>
                        <!-- SECTION TITLE -->
                        <p>ارائه سکو های مدرن برای کافه های (کسب و کار) شما ، متمرکز روی نیاز های شما برای رفع مشکلات و هدر رفتن نیروی انسانی</p>
                    </div>
                </div>
            </div>
            <div class="row service-box-wrap">
                <div class="col-md-3 col-sm-6 service-box-col">
                    <figure>
                        <div class="service-image">
                            <i class="flaticon-screen-1"></i>
                        </div>
                    </figure>
                    <h4 class="service-title title-bordered">مدیریت بدون محدودیت</h4>
                    <p class="service-content">فراهم سازی سکو بدون محدودیت وابستگی برای مدیریت و آماردهی جامع و هدفمند</p>
                </div>
                <div class="col-md-3 col-sm-6 service-box-col">
                    <figure>
                        <div class="service-image">
                            <i class="flaticon-smartphone"></i>
                        </div>
                    </figure>
                    <h4 class="service-title title-bordered">استفاده آسان</h4>
                    <p class="service-content">آساسن سازی سکو برای نیروی انسانی شما در صورت استفاده از هر نوع نیرو با هر دانش استفاده از فناوری</p>
                </div>
                <div class="col-md-3 col-sm-6 service-box-col">
                    <figure>
                        <div class="service-image">
                            <i class="flaticon-snowflake"></i>
                        </div>
                    </figure>
                    <h4 class="service-title title-bordered">دیجیتال مارکتینگ</h4>
                    <p class="service-content">استفاده دلخواه شما از سیستم تبلیغاتی هوشمند</p>
                </div>
                <div class="col-md-3 col-sm-6 service-box-col">
                    <figure>
                        <div class="service-image">
                            <i class="flaticon-star"></i>
                        </div>
                    </figure>
                    <h4 class="service-title title-bordered">محبوبیت</h4>
                    <p class="service-content">فراهم سازی رابط کاربری آسان برای مشتریان شما </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Section End -->
    <!-- Support Section Start -->
    <section class="section-parallax" data-src="{{asset('assets/home/images/bg/5.jpg')}}" data-stellar-background-ratio="0.5">
        <span class="overlay-section-bg black-section-bg"></span>
        <div class="container section-typo-white">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 text-center">
                    <h2 class="inline-content"><span>ما آماده آمدن هستیم</span></h2>
                    <!-- SECTION TITLE -->
                    <a class="btn btn-default btn-xl btn-bg-white btn-inline" href="#">شروع کنید!</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Support Section End -->
    <!-- Features Section Start -->
    @include('home._partial._features')
    <!-- Features Section End -->
    <!-- Counter Section Start -->
    @include('home._partial._counter')
    <!-- Counter Section End -->

    <!-- Our Plans Section Start -->
    @include('home._partial._plans')
    <!-- Our Plans Section End -->
    <!-- Subsribe Section Start -->
    @include('home._partial._subcribe_mail')
    <!-- Subsribe Section End -->
    <!-- Contact Section Start -->
    @include('home._partial._contact_us')
    <!-- Contact Section End -->
    <!-- Map Section Start -->
    <section class="padding-none">
        <!-- Map Styles -> Standard, Aubergine, Silver, Retro, Dark, Aubergine -->
        <div id="starkGoogleMap"  style="width:100%;height:400px;" data-map-style="Silver"></div>
    </section>
    <!-- Map Section End -->
    <!-- Our Clients Section Start -->
    <section class="padding-tb-40">
        <div class="container">
            <div class="row">
                <div dir="ltr" class="col-md-12">
                    <div class="client-slider-wrap">
                        <div class="owl-carousel client-slider" data-items="5" data-loop="true" data-margin="30" data-nav="false" data-slideby="1" data-dots="false" data-smart-speed="1000" data-left-arrow="fa fa-angle-left" data-right-arrow="fa fa-angle-right">
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/1.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/2.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/3.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/4.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/5.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/6.png')}}" /></a>
                            </div>
                            <div class="client-item">
                                <a href="#"><img alt="" class="img-responsive" src="{{asset('assets/home/images/clients/7.png')}}" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Clients Section End -->
    <!-- Footer Start -->
    @include('home._partial._footer')
    <!-- Footer End -->

</div><!-- .main-wrap -->


<!-- JQUERY LIBRARY -->
<script src="{{asset('assets/home/js/jquery.min.js')}}"></script>
<!-- BOOTSTRAP JS -->
<script src="{{asset('assets/home/js/bootstrap.min.js')}}"></script>
<!-- OWL CAROUSEL JS -->
<script src="{{asset('assets/home/js/owl.carousel.min.js')}}"></script>
<!-- APPEARS JS -->
<script src="{{asset('assets/home/js/jquery.appear.js')}}"></script>
<!-- EASING JS -->
<script src="{{asset('assets/home/js/jquery.easing.min.js')}}"></script>
<!-- STELLAR JS -->
<script src="{{asset('assets/home/js/jquery.stellar.min.js')}}"></script>
<!-- COUNTER JS -->
<script src="{{asset('assets/home/js/jquery.counterup.min.js')}}"></script>
<!-- ISOTOPE JS -->
<script src="{{asset('assets/home/js/isotope.pkgd.min.js')}}"></script>
<!-- LIGHTBOX JS -->
<script src="{{asset('assets/home/js/lightbox.min.js')}}"></script>
<!-- YTPLAYER JS -->
<script src="{{asset('assets/home/js/jquery.mb.YTPlayer.min.js')}}"></script>
<!-- BOOTSTRAP VALIDATOR JS -->
<script src="{{asset('assets/home/js/validator.min.js')}}"></script>
<!-- THEME JS -->
<script src="{{asset('assets/home/js/theme.js')}}"></script>
<!-- GOOGLE MAP INIT JS -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtkY02zM_XV3XtSzJbNwJdiA2iuNmP_bI&callback=initStarkContact" type="text/javascript"></script>
</body>
</html>

