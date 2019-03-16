@extends('index')

@section('title', '| Trip')

@section('content')
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
            padding: 140px 0;
            text-align: center;
            font-family: "Montserrat", sans-serif;
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
            padding: 50px 0;
            font-size: 3rem;
            text-transform: uppercase;
            color: #fff;
            background: rgba(84, 84, 84, 0.6);
            -moz-transition: all .5s;
            -webkit-transition: all .5s;
            transition: all .5s;
            font-family: 'Raleway', sans-serif;
            cursor: pointer;
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
        .timeline .country-block i.jp {

        }
        .timeline .country-block i.vt {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/vietnam-small.jpg");
        }
        .timeline .country-block i.cb {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/cambodia-small.jpg");
        }
        .timeline .country-block i.th {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/thailand-small.jpg");
        }
        .timeline .country-block i.ml {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/malaysia-small.jpg");
        }
        .timeline .country-block i.in {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/indonesia-small.jpg");
        }
        .timeline .country-block i.gr {
            background-image: url("http://asia.vasilis-tsirimokos.com/img/banners/greece-small.jpg");
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
        .timeline a:hover .country-block {
            background: rgba(9, 37, 57, 0.7);
            color: #dfa903;
        }
        .timeline a:hover .country-block i {
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
            border-radius: 10px;
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

        @media (min-width: 768px) {
            .modal-dialog {
                width: 1000px;
                margin: 30px auto;
            }
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
                @foreach($trip as $k => $tr)
                    <div class="row">

                            <div class="country-block
                                @if(fmod($tr['order'],'2') == 0)
                                    @php print_r('reverse col-sm-6 col-sm-push-6') @endphp
                                @else
                                    @php print_r('col-sm-6') @endphp
                                @endif " data-toggle="modal" data-target="#myModal" data-sid="{{$tr['id']}}" >
                                <i class="jp" style="background-image: url('{{$tr['image']}}');"></i>
                                {{$tr['booking']['country']}}
                            </div>

                        <div class="date-block
                            @if(fmod($tr['order'],'2') == 0)
                                @php print_r('reverse col-sm-6 col-sm-pull-6') @endphp
                            @else
                                @php print_r('col-sm-6') @endphp
                            @endif ">
                            <div>{{$tr['booking']['dep_date']}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">
                           Header
                        </h3>
                    </div>
                    <div class="modal-body">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                $('.modal-title').html(sid);
            });
        });

    </script>
@endsection