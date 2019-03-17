@extends('index')

@section('title', '| Trip')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/trip.css') }}">
    <style>
        /* latin-ext */
        @font-face {
            font-family: 'Raleway';
            font-style: normal;
            font-weight: 400;
            src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyCMIT5lu.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Raleway';
            font-style: normal;
            font-weight: 400;
            src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyC0ITw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Dosis';
            font-style: normal;
            font-weight: 400;
            src: local('Dosis Regular'), local('Dosis-Regular'), url(https://fonts.gstatic.com/s/dosis/v8/HhyaU5sn9vOmLzlmC_W6EQ.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Dosis';
            font-style: normal;
            font-weight: 400;
            src: local('Dosis Regular'), local('Dosis-Regular'), url(https://fonts.gstatic.com/s/dosis/v8/HhyaU5sn9vOmLzloC_U.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .navbar{
            margin-bottom: 0px;
        }

        body {
            background-image: url('') !important;
            background: #f2f2f2;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        a {
            text-decoration: none;
        }

        h3 {
            font-size: 3.1rem;
            font-weight: 500;
            margin: 0;
            font-family: 'Raleway';
            color: #545454;
        }

        h3 i{
            font-size: 30px;
            margin-right: 10px;
        }

        ::-moz-selection {
            color: #092539;
            background: #dfa903;
        }

        ::selection {
            color: #092539;
            background: #dfa903;
        }

        .white-stripe {
            background: #fff;
            text-align: center;
            padding: 30px 0;
        }
        .white-stripe p {
            margin-bottom: 0;
        }

        .white-stripe.arrow {
            position: relative;
        }
        .white-stripe.arrow::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 100%;
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 20px solid #fff;
            clear: both;
            margin-left: -20px;
            z-index: 10;
        }

        .timeline {
            position: relative;
            padding-top:140px ;
            padding-bottom: 80px;
            text-align: center;
            font-family: "Montserrat", sans-serif;
            min-height:  720px;
        }
        .timeline .row {
            margin-bottom: 50px;
        }
        @media only screen and (min-width: 768px) {
            .timeline .row {
                margin-bottom: 30px;
            }
        }
        .timeline::before {
            /* this is the vertical line */
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            margin-left: -2px;
            height: 100%;
            width: 3px;
            background: #dddddd;
            z-index: -2;
        }
        .timeline .country-block {
            padding: 75px 0;
            font-size: 3rem;
            text-transform: uppercase;
            color: #fff;
            background: rgba(84, 84, 84, 0.6);
            -moz-transition: all .5s;
            -webkit-transition: all .5s;
            transition: all .5s;
            font-family: 'Raleway', sans-serif;
            cursor: pointer;
            height: 200px;
        }
        .timeline .country-block i {
            content: '';
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            -moz-transition: background-size .3s;
            -webkit-transition: background-size .3s;
            transition: background-size .3s;
        }
        @media only screen and (min-width: 768px) {
            .timeline .country-block {
                width: 48%;
                margin-right: 2%;
            }
            .timeline .country-block::before, .timeline .country-block::after {
                content: '';
                position: absolute;
                right: -1px;
                height: 50%;
                padding-left: 3%;
                background: #f2f2f2;
                -ms-transform-origin: 100% 0;
                -webkit-transform-origin: 100% 0;
                transform-origin: 100% 0;
            }
            .timeline .country-block::before {
                bottom: 50%;
                -ms-transform: skewY(45deg);
                -webkit-transform: skewY(45deg);
                transform: skewY(45deg);
            }
            .timeline .country-block::after {
                top: 50%;
                -ms-transform: skewY(-45deg);
                -webkit-transform: skewY(-45deg);
                transform: skewY(-45deg);
            }
            .timeline .country-block.reverse {
                margin-left: 2%;
                margin-right: 0;
            }
            .timeline .country-block.reverse::before, .timeline .country-block.reverse::after {
                left: -1px;
                right: auto;
                -ms-transform-origin: 0 100%;
                -webkit-transform-origin: 0 100%;
                transform-origin: 0 100%;
            }
            .timeline .country-block.reverse::before {
                bottom: 50%;
                -ms-transform: skewY(-45deg);
                -webkit-transform: skewY(-45deg);
                transform: skewY(-45deg);
            }
            .timeline .country-block.reverse::after {
                top: 50%;
                -ms-transform: skewY(45deg);
                -webkit-transform: skewY(45deg);
                transform: skewY(45deg);
            }
        }
        .timeline a:hover, .timeline a:focus {
            text-decoration: none;
        }
        .timeline .country-block:hover {
            background: rgba(9, 37, 57, 0.7);
            color: #dfa903;
        }
        .timeline .country-block:hover i {
            background-size: 110%;
        }
        .timeline .date-block > div {
            position: relative;
            font-family: 'Raleway';
            font-weight: bold;
            font-size: 17px;
            background-color: #fff;
            padding: 10px 30px 10px 30px;
            border: 2px solid #7d7d7d;
            display: inline-block;
            margin-top: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        }
        @media only screen and (min-width: 768px) {
            .timeline .date-block > div {
                margin-top: 50px;
            }
        }
        @media only screen and (min-width: 768px) {
            .timeline .date-block::before {
                content: '';
                position: absolute;
                top: 60px;
                left: -10px;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                border: 4px solid #7d7d7d;
                background: #f2f2f2;
                box-shadow: 0 0 0 5px #f2f2f2;
                z-index: 10;
            }
            .timeline .date-block::after {
                content: '';
                position: absolute;
                top: 70px;
                left: 0;
                width: 50%;
                height: 3px;
                background: #dddddd;
                z-index: -1;
            }
            .timeline .date-block.reverse::before {
                right: -10px;
                left: auto;
            }
            .timeline .date-block.reverse::after {
                right: 0;
                left: auto;
            }
        }

        @media (min-width: 768px){
            .modal-dialog {
                width: 1200px;
                margin: 30px auto;
            }
        }

        .trip_period{
            font-size: 20px !important;
            font-family: 'Dosis', sans-serif !important;
        }

        .fa-home{
            font-size: 45px;
            color:  #7d7d7d;
            margin-top: 50px;
            margin-bottom: 20px;
            background-color: #f2f2f2;
        }

        .join_date{
            padding: 10px 30px 10px 30px;
            border: 2px solid #7d7d7d;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
            width: 330px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-family: 'Dosis', sans-serif !important;
            background-color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .modal-body{
            padding: 0px;
        }

        .modal-footer {
            padding: 5px;
        }

        .trip_header{
            height: 260px;
            background-position: 50% 25%;
            background-size: cover;
            opacity: 0.8;
        }

        .trip_header_country{
            padding-top: 120px;
            color: white;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-size: 30px;
            font-family: 'Raleway', sans-serif;
            text-transform: uppercase;
        }

        .trip_header_country span{
            color: black;
            background-color: white;
            border-radius: 5px;
            padding: 0 10px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="trip_container">
        <section class="white-stripe arrow">
            <div class="container">
                <h3>
                    <i class="fas fa-map-marked-alt"></i> Your Trip
                </h3>
            </div>
        </section>
        <section class="timeline">
            <div class="container">
                @if($trip != null)
                    @foreach($trip as $k => $tr)
                        <div class="row">
                                <div class="country-block
                                    @if(fmod($tr['order'],'2') == 0)
                                        @php print_r('reverse col-sm-6 col-sm-push-6') @endphp
                                    @else
                                        @php print_r('col-sm-6') @endphp
                                    @endif " data-toggle="modal" data-target="#myModal" data-sid="{{$tr['id']}}" data-img="{{$tr['image']}}" data-country="{{$tr['booking']['country']}}">
                                    <i class="jp" style="background-image: url('{{$tr['image']}}');"></i>
                                    {{$tr['booking']['country']}}
                                </div>

                            <div class="date-block
                                @if(fmod($tr['order'],'2') == 0)
                                    @php print_r('reverse col-sm-6 col-sm-pull-6') @endphp
                                @else
                                    @php print_r('col-sm-6') @endphp
                                @endif ">
                                <div class="trip_period">{{$tr['booking']['dep_date']}}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row">
                        <a href="flight">
                            <div class="country-block col-sm-6">
                                <i class="jp" style="background-image: url('{{URL::to('/')}}/images/travel_trip.jpg');"></i>
                            </div>
                        </a>
                        <div class="date-block col-sm-6">
                            <div>Want to have a new trip? Book Hotel or Flight now!</div>
                        </div>
                    </div>
                @endif
            </div>

            <i class="fas fa-home"></i>
            <div class="join_date">You joined hotelsDB at {{$join}}</div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="trip_header">
                            <div class="trip_header_country">
                                <span></span>
                            </div>
                        </div>

                        <div class="trip_content">
                            <!-- Get info via ajax -->

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeDefault.css" rel="stylesheet" type="text/css"/>
    <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
    <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shAutoloader.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPhp.js"></script>
    <script type="text/javascript">
        SyntaxHighlighter.all()
    </script>

    <script>

        $('.country-block').each(function () {
            $(this).on("click", function () {
                var sid = $(this).data('sid');
                var img = $(this).data('img');
                var country = $(this).data('country');

                $('.trip_header').css("background-image", "url('"+img+"')");
                $('.trip_header_country span').html(country);

                //ajax to load trip details
                $('.trip_content').load('trip/'+sid+' .trip_details', function () {});
            });
        });

    </script>
@endsection