<!-- Default Bootstrap Navbar -->
<style>
    .navbar-default {
        background-color: #2d6098;
    }

    .navbar-default .navbar-nav > li > a {
        /*color: #c4fbcc;*/
        color: white;
        font-family: 'Quicksand', sans-serif !important;
    }

    .navbar {
        font-family: 'Noto Sans TC', sans-serif; /* TC */
        /*font-family: 'Chakra Petch', sans-serif;    //EN */
    }

    .navbar {
        font-size: 16px;
        min-height: 70px !important;
        border-radius: 0px;
        border-top: 0px;
        border-right: 0px;
        border-left: 0px;
        border-bottom: 1px solid #000;
    }

    .navbar-default .navbar-nav > .active > a {
        color: #fff;
        background-color: #4575aa;
    }

    .nav_logo {
        height: 55px;
        width: auto;
    }

    .navbar-hotelsdb {
        padding-left: 10px;
        padding-right: 15px;
    }

    .navbar-header {
        margin-right: 45px !important;
    }

    @media (max-width: 990px) {
        .navbar-header {
            margin-right: 0px !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-nav > li > a {
            padding-top: 25px !important;
            padding-bottom: 25px !important;
        }
    }

    .navbar-header {
        margin-top: 5px !important;
    }

    .cool-link {
        width: 130px;
        text-align: center;
    }

    .cool-link {
        display: inline-block;
        color: #e7e7e7;
        text-decoration: none;
    }

    .cool-link:hover {
        background-color: #4575aa;
        transition: all .2s;
    }

    .cool-link a:hover {
        color: #fff !important;
        transition: all .2s;
    }

    .cool-link::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: #fff;
        transition: width .53s;
    }

    .cool-link:hover::after {
        width: 100%;
        transition: width .3s;
    }

    @media (max-width: 768px) {
        .cool-link {
            width: 100% !important;
        }

        .dropdown-menu {
            text-align: left;
        }

        .dropdown-menu li{
            padding-left: 30%;
        }
    }

    .nav .active::after {
        content: '';
        display: block;
        height: 2px;
        background: #e7e7e7;
        width: 100%;
    }

    .dropdown a:hover{
        color: #969696 !important;
    }

    .dropdown-menu{
        font-size: 16px;
    }

    .nav_user_box{
        text-transform: capitalize;
        font-size: 110%;
    }

    .nav_user_box i{
        font-size: 20px;
    }
</style>


<nav class="navbar navbar-default fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-hotelsdb" href="#">
                <a href="{{asset('/')}}"><img src="{{asset('/images/logo2_s.png')}}" class="nav_logo"></a>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? "active" : "" }} cool-link"><a href="{{asset('/')}}">HOME</a></li>
                <li class="{{ Request::is('allhotels') ? "active" : "" }} cool-link"><a href="{{asset('/allhotels')}}">HOTELS</a>
                </li>
                <li class="{{ Request::is('flight') ? "active" : "" }} cool-link"><a href="{{asset('/flight')}}">FLIGHTS</a>
                </li>
                <li class="<?php if(Request::is('trip/plan') || Route::getCurrentRoute()->getPath() == 'trip/itinerary/{id}'
                || Route::getCurrentRoute()->getPath() == 'trip/itinerary/all/{user_id}' ){
                    echo 'active';
                }?> cool-link"><a href="{{asset('/trip/plan')}}">ITINERARIES</a>
                </li>
                <li class="{{ Request::is('about') ? "active" : "" }} cool-link"><a href="{{asset('/about')}}">ABOUT</a>
                </li>
                <li class="{{ Request::is('contact') ? "active" : "" }} cool-link"><a
                            href="{{asset('/contact')}}">ASSIST</a></li>

                <li class="{{ Request::is('article') ? "active" : "" }} cool-link"><a
                            href="{{asset('/article')}}">DOCS</a></li>

                {{--<li class="{{ Request::is('blog') ? "active" : "" }}"><a href="{{asset('/blog')}}">Blog</a></li>--}}
                {{--<li class="{{ Request::is('about') ? "active" : "" }}"><a href="{{asset('/about')}}">About</a></li>--}}
                {{--<li class="{{ Request::is('contact') ? "active" : "" }}"><a href="{{asset('/contact')}}">Contact</a></li>--}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())

                    <li class="dropdown">
                        <a href="/" class="dropdown-toggle nav_user_box" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><i class="fas fa-user-circle"></i> &nbsp; {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->role == 'superadmin')
                                <li><a href="{{ route('admin.user') }}"><i class="fas fa-users-cog"></i> &nbsp; Users</a></li>
                                <li><a href="{{ route('admin.hotel') }}"><i class="fas fa-hotel"></i> &nbsp; Hotels</a></li>
                                <li><a href="{{ route('categories.index') }}"><i class="fas fa-box-open"></i> &nbsp; Categories</a></li>
                                <li><a href="{{ route('tags.index') }}"><i class="fas fa-tags"></i> &nbsp; Tags</a></li>
                            @endif

                                <li><a href="{{ route('hotel.booklist') }}"><i class="fas fa-bed"></i> &nbsp; Booking</a></li>
                                <li><a href="{{ route('hotel.payment') }}"><i class="far fa-credit-card"></i> &nbsp; Payment</a></li>
                                <li><a href="{{ route('flight.summary') }}"><i class="fas fa-plane-departure"></i> &nbsp; Flight</a></li>
                                <li><a href="{{ route('flight.itinerary_all',Auth::user()->id) }}"><i class="fas fa-umbrella-beach"></i> &nbsp; Itinerary</a></li>
                                <li><a href="{{ route('flight.trip') }}"><i class="fas fa-map-marked"></i> &nbsp; Trip</a></li>

                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('account') }}"><i class="fas fa-user-circle"></i> &nbsp; Account</a></li>
                            <li><a href="{{ route('facebook') }}"><i class="fab fa-facebook"></i> &nbsp; Facebook</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout</a></li>
                        </ul>
                    </li>

                @else
                    <li class="cool-link"><a href="{{route('login')}}">LOGIN</a></li>
                    <li class="cool-link"><a href="{{route('register')}}">REGISTER</a></li>
                    {{--<a href="{{ route('login') }}" class="btn btn-default">Login</a>--}}

                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>