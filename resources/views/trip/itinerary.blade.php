@php
    use App\TripAdviser;
@endphp

@extends('index')

@section('title', '| Trip Itinerary')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <style type="text/css" class="cp-pen-styles">

        body {
            background-image: url('') !important;
            background: #f2f2f2;
            font-family: 'Quicksand', sans-serif !important;
        }

        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
        }
        .lds-ellipsis div {
            position: absolute;
            top: 27px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #2d6098;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
        .lds-ellipsis div:nth-child(1) {
            left: 6px;
            animation: lds-ellipsis1 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(2) {
            left: 6px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(3) {
            left: 26px;
            animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(4) {
            left: 45px;
            animation: lds-ellipsis3 0.6s infinite;
        }
        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }
        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(19px, 0);
            }
        }

        .loading_css{
            margin-left: 22%;
            margin-right: 22%;
            margin-top: 100px;
            text-align: center;
        }

        .loading_text{
            font-size: 20px;
        }

        @media (min-width: 768px){
            .modal-dialog {
                width: 1200px;
                margin: 30px auto;
            }
        }

        .modal-body{
            padding: 0px;
        }

        .modal-footer {
            padding: 5px;
        }

        .container_itinerary {
            margin-top: 35px;
            margin-left: 15%;
            margin-right: 15%;
            padding: 0 20px;
            margin-bottom: 150px;
            display:none;
        }
        
        .itinerary_box{
            /*margin-bottom: 20px;*/
        }
        
        .itinerary_poi{
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: solid 1px #dbdbdb;
            padding-top: 25px;
            padding-bottom: 25px;
        }
        
        .line-between, .line-between-long, .line-between-longest{
            border-left: 2px solid #dedede;
            margin-left: 40px;
        }
        
        .line-between{
            height: 30px;
        }
        
        .line-between-long{
            height: 70px;
        }
        
        .mdate{
            height: 36px;
            border-radius: 100px;
            background-color: #333;
            font-size: 18px;
            font-weight: 900;
            line-height: 1.78;
            text-align: center;
            color: #fff;
            display: inline-block;
            padding: 2px 25px;
            margin-left: -18px;
        }
        
        .itinerary_time{
            font-size:16px;
            font-weight: bold;
            padding-left: 30px;
            color: #474747;
        }

        .schedule_time{
            display: block;
            font-size: 27px;
        }
        
        .itinerary_img img{
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: solid 1px #f0eded;
            width: 150px;
            height: 150px;
        }
        
        .itinerary_details{
            padding-left: 50px;
        }

        .itinerary_details h3{
            margin-top: 0px;
        }
        
        .itinerary_transport{
            padding-left: 40px;
            font-style: italic;
            cursor: pointer;
            width: 170px;
        }

        .itinerary_dayend{
            padding-left: 30px;
        }

        .itinerary_dayend i{
            border: 2px solid #c3c3c3;
            border-radius:10%;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: solid 1px #f0eded;
        }
        
        .itinerary_transport i , .itinerary_dayend i{
            font-size: 25px;
            margin-right: 10px;
        }

        .eachday{
            /*margin-bottom: 100px;*/
        }

        .line-between-longest{
            height: 150px;
        }

        .marker{
            float: right;
            font-size: 12px;
            cursor: pointer;
            border: 1px solid #818181;
            padding: 5px;
            border-radius: 5px;
            transition: 0.2s;
        }

        .marker:hover{
            color: white;
            background-color: black;
        }

        .transport_button{
            display: inline-block;
            cursor: pointer;
            transition: 0.2s all;
        }

        .transport_button:hover{
            color: #d5d5d5;
        }

        .linked{
            font-size: 15px;
        }

        .fa-directions{
            cursor: pointer;
        }

        @media only screen and (max-width: 800px) {
            #myScrollspy {
                display: none;
            }
        }

        .affix {
            top: 20px;
            /*z-index: 9999 !important;*/
        }

        .nav-pills{
            border-left: 1px solid black;
        }

        .nav-pills li{
            width: 60px;
        }

        .nav-pills li a{
            font-size: 14px;
            font-weight: bold;
            color: black;
        }

        .right_itinerary{
            padding-left: 50px;
        }

        .top_tab{
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            letter-spacing: 2px;
        }

        .timeline_tab{
            margin-right: 15px;
            border-bottom: 2px solid black;
            cursor: pointer;
        }

        .calendat_tab{
            border-left: 1px solid black;
            padding-left: 15px;
            cursor: pointer;
        }

        .see_more{
            display: inline-block;
            cursor: pointer;
        }
    </style>

    <div class="loading_css">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> <br>
        <div class="loading_text">Generating and formatting itineraries, please wait...</div>
    </div>
    <body data-spy="scroll" data-target="#myScrollspy" data-offset="15">
    <div class="container_itinerary">

        <div class="row top_tab">
            <div class="col-md-12">
                <span class="timeline_tab">TIMELINE</span>
                <span class="calendat_tab">CALENDAR</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">
                <nav class="col-sm-3" id="myScrollspy">
                    <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">
                        @foreach($itinerary['dates'] as $i => $date)
                            <li><a href="#day{{$i+1}}">{{substr($date,0,-5)}}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>

            <div class="col-md-11 right_itinerary">
                @foreach($itinerary['dates'] as $i => $date)
                    <div class="eachday" id="day{{$i+1}}">
                        <div class="mdate">
                            {{$date}}
                        </div>
                        <div class="line-between-long"></div>
                        @if($i == 0)
                            <div class="row itinerary_dayend">
                                <i class="fas fa-plane-arrival"></i>
                                @if($related_flight_id == null)
                                    Arrival
                                @else
                                    <i class="fas fa-directions" data-toggle="modal" data-target="#iftameFlight" onclick="openflight('<?php echo $related_flight_id ?>')"></i>
                                    <span class="linked">You had linked a flight booking.</span>
                                @endif
                            </div>
                            <div class="line-between"></div>
                        @endif
                        @foreach($itinerary['schedule'][$i][$date] as $s => $poi)
                            @if($poi['type'] == "poi")
                                <div class="row itinerary_box">
                                    <div class="col-md-12 itinerary_poi">
                                        <div class="row">
                                            <div class="col-md-2 itinerary_time">
                                                <span class="schedule_time">{{substr($poi['schedule_time'], -8,-3)}}</span>
                                                <i class="far fa-clock"></i> &nbsp;{{$poi['duration']/60}} Minutes
                                            </div>
                                            <div class="col-md-2 itinerary_img">
                                                @if($poi['thumbnail_url'] != null)
                                                    <img src="{{$poi['thumbnail_url']}}">
                                                @else
                                                    <img src="{{asset('/images/no_image.jpg')}}">
                                                @endif
                                            </div>
                                            <div class="col-md-8 itinerary_details">
                                                <h3>{{$poi['location']}}</h3>
                                                @if($poi['rating'] > 0.5)
                                                    @for ($r = 0; $r < 6; $r++)
                                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                    @endfor
                                                @elseif($poi['rating'] > 0.3)
                                                    @for ($r = 0; $r < 5; $r++)
                                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                    @endfor
                                                @elseif($poi['rating'] > 0.1)
                                                    @for ($r = 0; $r < 4; $r++)
                                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                    @endfor
                                                @elseif($poi['rating'] > 0.05)
                                                    @for ($r = 0; $r < 3; $r++)
                                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                    @endfor
                                                @else
                                                    <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                    <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                @endif
                                                <br><br>
                                                {{$poi['perex']}} <br><br>
                                                <div class="see_more" data-toggle="modal" data-target="#detailsModal" onclick="loadDetails('<?php echo $poi['poi_id'] ?>')">
                                                    <i class="fas fa-info-circle"></i> See more details
                                                </div>
                                                <br>
                                                <span class="marker" data-toggle="modal" data-target="#iftameMarker" onclick="loadMap('<?php echo $poi['coordinate'] ?>')">
                                                    <i class="fas fa-map-marker-alt"></i> Maps
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($s != count($itinerary['schedule'][$i][$date]) - 1)
                                    <div class="line-between"></div>
                                @endif
                            @elseif($poi['type'] == "hotel")
                                <div class="row itinerary_box">
                                    <div class="col-md-12 itinerary_poi">
                                        <div class="row">
                                            <div class="col-md-2 itinerary_time">
                                                <span class="schedule_time">{{substr($poi['schedule_time'], -8,-3)}}</span>
                                                <i class="fas fa-suitcase-rolling"></i>
                                            </div>
                                            <div class="col-md-2 itinerary_img">
                                                <img src="https://upload.cc/i1/2019/10/04/DnFrW4.jpg">
                                            </div>
                                            <div class="col-md-8 itinerary_details">
                                                <h3>{{ucfirst($poi['location'])}}</h3>
                                                <br><br>
                                                <i class="fas fa-location-arrow"></i>&nbsp;{{$poi['perex']}} <br><br>
                                                <br>
                                                <span class="marker" data-toggle="modal" data-target="#iftameMarker" onclick="loadMap('<?php echo $poi['coordinate'] ?>')">
                                                    <i class="fas fa-map-marker-alt"></i> Maps
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($s != count($itinerary['schedule'][$i][$date]) - 1)
                                    <div class="line-between"></div>
                                @endif
                            @elseif($poi['type'] == "transport")
                                <div class="row itinerary_transport" data-toggle="modal" data-target="#iftameModal" onclick="loadIframe('<?php echo $itinerary['schedule'][$i][$date][$s-1]['coordinate']?>','<?php echo $itinerary['schedule'][$i][$date][$s+1]['coordinate']?>')">
                                    <i class="fas fa-car-side"></i>
                                    <div class="transport_button">
                                         {{floor($poi['duration']/60)}} Minutes
                                    </div>
                                </div>
                            <div class="line-between"></div>
                            @endif
                        @endforeach
                    </div>
                    @if($i != count($itinerary['dates']) - 1)
                        <div class="line-between"></div>
                        <div class="row itinerary_dayend">
                            <i class="fas fa-bed"></i> End of the day
                        </div>
                        <div class="line-between-longest"></div>
                    @else
                        <div class="line-between-longest"></div>
                        <div class="row itinerary_dayend">
                            <i class="fas fa-plane-departure"></i> Back to original country
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


    <!----------------- Modal Part ----------------->

    <div class="modal fade" id="iftameModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe id="google_iframe" src="" width="100%" height="650" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="iftameMarker" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe id="place_point" src="" width="100%" height="650" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="iftameFlight" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    123123
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailsModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                   <span id="poi_name">TEXT</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

<script>
    window.onload = function() {
        setTimeout(function(){
            $(".container_itinerary").css("display", "block");
            $(".loading_css").hide();
        }, 800);
    };

    function loadIframe(from,to) {
        var $iframe = $('#google_iframe');
        if ( $iframe.length ) {
            var url = "https://www.google.com/maps/embed/v1/directions?key=AIzaSyBs37KmdWQjAdOeIon2W_kg7hDfAOF_Fhc&origin="+from+"&destination="+to;
            $iframe.attr('src',url);
            return false;
        }
        return true;
    }

    function loadMap(point){
        var $iframe = $('#place_point');
        if ( $iframe.length ) {
            var url = "http://maps.google.com/maps?q="+point+"&z=15&output=embed";
            $iframe.attr('src',url);
            return false;
        }
        return true;
    }

    function openflight(id) {
        $('#iftameFlight .modal-body').load('flight-summary?id='+id+' .table-responsive', function () {

        });
    }

    $(".nav-pills li a[href^='#']").on('click', function(e) {

        // prevent default anchor click behavior
        e.preventDefault();

        // store hash
        var hash = this.hash;

        // animate
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 400, function(){

            // when done, add hash to url
            // (default click behaviour)
            window.location.hash = hash;
        });

    });

    //Load json from PHP to javascript
    var poi_data = {!! json_encode($poi_data) !!};

    function loadDetails(id) {
        var name = poi_data[id]['original_name'];

        $('#detailsModal #poi_name').html(name);
    }

</script>

@endsection