@php
    use App\TripAdviser;
@endphp

@extends('index')

@section('title', '| Trip Itinerary')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#sortable, #sortable2" ).sortable({
                opacity: 0.4,
                connectWith: ".connectedSortable"
            });
            $( "#sortable, #sortable2" ).disableSelection();
        } );
    </script>
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
            padding: 10px;
        }

        .modal-footer {
            padding: 5px;
        }

        .middle {
            position: relative;
            height:500px;
        }

        @media only screen and (max-width: 800px) {
            .middle {
                height:250px;
            }
        }

        .middle img {
            max-width: 100%;
            max-height:100%;
            margin: auto;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
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
            font-size: 30px;
            margin-bottom: 5px;
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
            display: none;  /* Disable currently */
        }

        .see_more{
            display: inline-block;
            cursor: pointer;
        }

        #detailsModal{
            color: black;
        }

        .poi_content{
            font-size: 14px;
            color: #3f3f3f;
        }

        .poi_content i{
            margin-right: 5px;
            width: 15px;
        }

        .poi_content b{
            font-size: 15px;
        }

        .poi_content_header{
            margin: 5px 5px 5px 5px;
            font-size: 24px;
            font-weight: bold;
        }

        .poi_star i{
            font-size: 16px;
        }

        .poi_desc{
            padding: 10px;
        }

        .poi_category{
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .poi_text{
            font-size: 16px;
        }

        .poi_address, .poi_admission, .poi_opening, .poi_phone, .poi_map{
            margin-top: 40px;
        }

        #place_map{
            border: 1px solid #7b7b7b;
            border-radius: 5px;
        }

        .update_itinerary, .update_view{
            float: right;
            font-size: 30px;
            border-radius: 5px;
            padding: 1px 7px 1px 7px;
            cursor: pointer;
        }

        .update_view{
            background: #333333;
            color: white;
            font-size: 24px;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-top: 3px;
            width: 26px;
            height: 26px;
        }

        .day_itinerary{
            margin-left: 2%;
            margin-right: 2%;
        }

        .edit_each_poi {
            border: 1px solid #ccc;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: all-scroll;
        }

        .edit_each_poi img{
            width:70px;
            height: auto;
        }

        .edit_leftside, .edit_rightside{
            display: inline-block;
            vertical-align: top;
        }

        .edit_leftside{
            margin-right:15px;
        }

        .edit_title{
            font-size: 18px;
        }

        .edit_duration:hover , .edit_delete:hover{
            color: red;
        }

        .edit_delete{
            float: right;
            margin-top: 10px;
            margin-right: 10px;
        }

        #save-update{
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        .edit_timeflag{
            margin-top:8px;
        }

        .edit_time_left{
            padding-top: 10px;
            border: 1px solid #d1d1d1;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        #editItinerary .modal-body{
            padding:20px;
        }
        
        .edit_box{
            margin-left: 0px;
            margin-right: 0px;
        }
        
        .add_area{
            margin-top: 10px;
        }

        .add_area .edit_title{
            font-size: 12px;
        }

        .add_area .edit_rightside{
            max-width: 140px;
        }

        #sortable2{
            min-height: 50px;
            border: 1px dotted #d7d7d7;
            border-radius: 5px;
        }

        .drop_notice{
            color: #c0c0c0;
        }
        
        .ui-sortable-placeholder{
            height: 55px;
            visibility: visible !important;
            color: #ddd !important;
        }
        
        .not_found_msg{
            margin: 10px;
        }


        /* Custom radio buttons */
        input[type="radio"] + label {
            display: inline-block;
            cursor: pointer;
            position: relative;
            padding-left: 30px;
            margin-right: 15px;
            font-size: 17px;
        }
        input[type="radio"] + label:before {
            content: "";
            display: block;
            width: 22px;
            height: 22px;
            margin-right: 14px;
            position: absolute;
            top: -3px;
            left: 0;
            border: 1px solid #aaa;
            background-color: #fff;
            border-radius: 50%;
        }
        input[type="radio"] {
            display: none !important;
            *display: inline;
        }
        input[type="radio"]:checked + label:after {
            content: "";
            display: block;
            position: absolute;
            top: 2px;
            left: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #173848;
        }
        /* Custom checkbox */
        input[type="checkbox"] + label {
            display: inline-block;
            cursor: pointer;
            position: relative;
            padding-left: 30px;
            margin-right: 15px;
            font-size: 13px;
        }
        input[type="checkbox"] + label:before {
            content: "";
            display: block;
            width: 22px;
            height: 22px;
            margin-right: 14px;
            position: absolute;
            top: -3px;
            left: 0;
            border: 1px solid #aaa;
            background-color: #fff;
            border-radius: 5px;
        }
        input[type="checkbox"] {
            display: none !important;
            *display: inline;
        }
        input[type="checkbox"]:checked + label:after {
            content: "✔";
            font-size: 20px;
            line-height: 20px;
            color: #b7b7b7;
            display: block;
            position: absolute;
            top: 0;
            left: 4px;
            width: 20px;
            height: 20px;
            border-radius: 3px;
        }

        .radio label, .radio2 label{
            font-weight: normal !important;
        }

        .radio, .radio2{
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .room_view span{
            font-size: 18px;
            font-weight: bold;
        }

        .room_view h3{
            margin-bottom: 30px;
        }

        .saving_view{
            margin-top: 30px;
            margin-bottom: 10px;
        }
    </style>
    <body data-spy="scroll" data-target="#myScrollspy" data-offset="15">
        <div class="loading_css">
            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> <br>
            <div class="loading_text">Generating and formatting itineraries, please wait...</div>
        </div>

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
                        <div class="dayofday dayof_{{$i}}">
                            <i class="fas fa-pen-square update_itinerary" onclick="editMode('{{$i}}')" data-toggle="modal" data-target="#editItinerary"></i>
                            @if($hotel_details != null)
                                <i class="fas fa-eye update_view" onclick="editView('{{$i}}')" data-toggle="modal" data-target="#editView"></i>
                            @endif
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
                                                        <i class="fas fa-hourglass-half"></i> &nbsp;{{$poi['duration']/60}} Minutes
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
                                    
                                        @if( ($stay == null) || ($s == 1 && $stay['roomflag'][$i]['start'] == 1) || ($s != 1 && $stay['roomflag'][$i]['end'] == 1)  )
                                            <div class="row itinerary_box">
                                                <div class="col-md-12 itinerary_poi">
                                                    <div class="row">
                                                        <div class="col-md-2 itinerary_time">
                                                            <span class="schedule_time">{{substr($poi['schedule_time'], -8,-3)}}</span>
                                                            <i class="fas fa-hotel"></i>
                                                        </div>
                                                        <div class="col-md-2 itinerary_img">
                                                            <img src="https://room-matehotels.com/images/img/general/small/slide_home_alba.jpg">
                                                        </div>
                                                        <div class="col-md-8 itinerary_details">
                                                            <h3>{{ucfirst($poi['location'])}} / Accommodation</h3>
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
                                        @endif
                                        
                                    @elseif($poi['type'] == "transport")
                                        <?php
                                            if(isset($itinerary['schedule'][$i][$date][$s-1]['coordinate'])){
                                                $xstart = $itinerary['schedule'][$i][$date][$s-1]['coordinate'];
                                            } else { $xstart = null;}

                                            if(isset($itinerary['schedule'][$i][$date][$s+1]['coordinate'])){
                                                $xnext = $itinerary['schedule'][$i][$date][$s+1]['coordinate'];
                                            } else { $xnext = $itinerary['schedule'][$i][$date][$s+2]['coordinate'];}
                                        ?>
                                        @if($xstart != null)
                                            <div class="row itinerary_transport" data-toggle="modal" data-target="#iftameModal" onclick="loadIframe('<?php echo $xstart?>','<?php echo $xnext?>')">
                                                <i class="fas fa-car-side"></i>
                                                <div class="transport_button">
                                                     {{floor($poi['duration']/60)}} Minutes
                                                </div>
                                            </div>
                                        <div class="line-between"></div>
                                        @endif
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
                        </div>
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
                        <!-- flight details -->
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
                        <div class="poi_content_header">
                            <span class="poi_name">#NAME</span> - <span class="poi_oname">#ONAME</span>
                            <span class="poi_star"><i class="fas fa-star" style="color: #ff9600;"></i></span>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">

                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">

                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <div class="poi_desc">
                                    <div class="poi_category">
                                        <b>Category</b> : <span>#CATEGORIES</span>
                                    </div>
                                    <div class="poi_text">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="poi_content">
                                    <div class="poi_duration">
                                        <b><i class="fas fa-hourglass-half"></i> Recommended Duration</b> <br>
                                        <span></span>
                                    </div>
                                    <div class="poi_address">
                                        <b><i class="fas fa-location-arrow"></i> Address</b> <br>
                                        <span></span>
                                    </div>
                                    <div class="poi_admission">
                                        <b><i class="fas fa-dollar-sign"></i> Admission</b> <br>
                                        <span></span>
                                    </div>
                                    <div class="poi_opening">
                                        <b><i class="fas fa-clock"></i> Opening Hours</b> <br>
                                        <span></span>
                                    </div>
                                    <div class="poi_phone">
                                        <b><i class="fas fa-mobile-alt"></i> Phone</b> <br>
                                        <span></span>
                                    </div>
                                    <div class="poi_map">
                                        <b><i class="fas fa-map-marked-alt"></i> Location</b> <br>
                                        <iframe id="place_map" src="" width="100%" height="300" frameborder="0" allowfullscreen=""></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editItinerary" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row edit_box">
                            <div class="col-md-2 edit_time_left">
                                <i class="far fa-clock"></i> DAY START TIME
                                <div class="edit_timeflag">
                                    <input id="day_starttime" class="form-control" type="text" maxlength="30" autocomplete="off">
                                </div>
                                <hr>

                            </div>
                            <div class="col-md-7">
                                <div class="day_itinerary connectedSortable" id="sortable"></div>
                                <div class="day_itinerary_save"></div>
                            </div>
                            <div class="col-md-3">
                                <input id="keyword" class="form-control" type="text" maxlength="30" autocomplete="off" placeholder="Where do you want to go?">
                                <button type="button" class="btn btn-primary" onclick="searchPoi()">Search</button>
                                <div class="not_found_msg"></div>
                                <div class="add_area connectedSortable" id="sortable2"></div>
                                <div class="drop_notice"><i class="fas fa-hand-lizard"></i> Drop to add into your itinerary!</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editView" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row room_view">
                            <div style="text-align: center">
                                <h3>Do you want to display the accommodation into your itinerary of that day?</h3>
                                <span> - Start from the day - </span>
                                <div class="radio"></div>
                                <br>
                                <span> - End from the day - </span>
                                <div class="radio2"></div>
                                <div class="saving_view"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </body>
@endsection

@section('scripts')

<script>
    window.onload = function() {
        //setTimeout(function(){
            $(".container_itinerary").css("display", "block");
            $(".loading_css").hide();
        //}, 800);
    };

    function loadIframe(from,to) {
        var $iframe = $('#google_iframe');
        if ( $iframe.length ) {
            var url = "https://www.google.com/maps/embed/v1/directions?key="+map_key+"&origin="+from+"&destination="+to;
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
    var map_key = {!! json_encode($api_key) !!};

    function loadDetails(id) {
        console.log(poi_data[id]);

        //POI Header
        var name = poi_data[id]['name'];
        var original_name = poi_data[id]['original_name'];
        var rating = poi_data[id]['rating'];
        $('#detailsModal .poi_name').html(name);
        $('#detailsModal .poi_oname').html(original_name);

        var star_html = '';
        var star = '<i class="fas fa-star" style="color: #ff9600;">';
        switch (true) {
            case rating > 0.5:
                for (var i = 0; i < 6; i++) {
                    star_html += star;
                }
                break;
            case rating > 0.3:
                for (var i = 0; i < 5; i++) {
                    star_html += star;
                }
                break;
            case rating > 0.1:
                for (var i = 0; i < 4; i++) {
                    star_html += star;
                }
                break;
            case rating > 0.05:
                for (var i = 0; i < 3; i++) {
                    star_html += star;
                }
                break;
            default:
                star_html += star+star;
        }
        $('.poi_star').html(star_html);


        //POI Carousel
        if(poi_data[id]['main_media'] != null) {
            var media = poi_data[id]['main_media']['media'];
            var main_img = media[0]['url'];

            var media_html = '';
            var indicators = '';
            media_html = '<div class="item active"><div class="middle"><img src="' + main_img + '" alt=""></div></div>';
            indicators = '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
            setTimeout(function () {
                $.each(media, function (key, value) {
                    if (key > 0) {
                        media_html += '<div class="item"><div class="middle"><img src="' + value['url'] + '" alt=""></div></div>';
                        indicators += '<li data-target="#myCarousel" data-slide-to="' + key + '"></li>';
                    }
                });

                $("#myCarousel .carousel-inner").html(media_html);
                $("#myCarousel .carousel-indicators").html(indicators);
            }, 500);
        } else {
            media_html = '<div class="item active"><div class="middle"><img src="../../images/no_image.jpg" alt=""></div></div>';
            $("#myCarousel .carousel-inner").html(media_html);
        }

        //POI desc
        var categories = poi_data[id]['categories'];
        var cat_str = '';
        $.each( categories, function( key, value ) {
            if(key < categories.length - 1){
                cat_str += value+' / ';
            } else {
                cat_str += value;
            }
        });
        $(".poi_category span").html('<i>'+cat_str+'</i>');

        if(poi_data[id]['description'] != null) {
            var desc_text = poi_data[id]['description']['text'];
            $(".poi_text span").text(desc_text);
        }

        //POI Content
        var duration = poi_data[id]['duration'];
        var recom_duration_from;
        var recom_duration_to;
        var duration_str = '';
        if(duration != null){
            recom_duration_from = (duration/60);
            recom_duration_to = ((duration + 1800)/60);
            duration_str = recom_duration_from+ ' to ' +recom_duration_to + ' Minutes';
            $(".poi_duration span").html(duration_str);
        }

        var address = poi_data[id]['address'];
        $(".poi_address span").html(address);

        var admission = poi_data[id]['admission'];
        if(admission != null) {
            $(".poi_admission span").html(admission);
        } else {
            $(".poi_admission span").html('No.');
        }

        var opening = poi_data[id]['opening_hours'];
        if(opening != null) {
            $(".poi_opening span").text(opening);
        } else {
            $(".poi_opening span").text("No information provided.");
        }

        var phone = poi_data[id]['phone'];
        if(phone != null){
            $(".poi_phone span").text(phone);
        } else {
            $(".poi_phone span").text('No information provided.');
        }

        var location = poi_data[id]['location'];
        location = location.lat+','+location.lng;

        var $iframe = $('#place_map');
        if ( $iframe.length ) {
            var url = "http://maps.google.com/maps?q="+location+"&z=15&output=embed";
            $iframe.attr('src',url);
            return false;
        }
    }

</script>
<script>

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var edit_itinerary = {!! json_encode($edit_itinerary) !!};
    var itinerary_timeflag = {!! json_encode($itinerary_timeflag) !!};
    var hotel_details = {!! json_encode($hotel_details) !!};
    var stay_details = {!! json_encode($stay) !!};

    function editMode(day){
        console.log(day);
        console.log(edit_itinerary[day]);
        console.log(itinerary_timeflag[day]);

        
        //Display timeflag field
        $("#day_starttime").val(itinerary_timeflag[day].starttime);
        //$("#day_endtime").val(itinerary_timeflag[day].endtime);
        

        //Display whole schedule
        var edithtml = '';

        $.each( edit_itinerary[day], function( key, value ) {
            edithtml += '<div class="edit_each_poi" id="poi-'+value['poi'].substring(4)+'">';

                edithtml += '<div class="edit_leftside">';
                if(value['thumbnail'] != null) {
                    edithtml += '<img src="' + value['thumbnail'] + '">';
                } else {
                    edithtml += '<img src="../../images/no_image.jpg">';
                }
                edithtml += '</div>';

                edithtml += '<div class="edit_rightside">';
                edithtml += '<span class="edit_title"><b>'+value['location']+'</b></span><br>';
                //edithtml += '<span><i class="far fa-clock"></i> <b>'+value['time'].substring(9)+'</b></span><br>';
                edithtml += '<span class="edit_duration" onclick="editDuration('+value['poi'].replace("poi:", "")+')"><i class="far fa-clock"></i> <b>'+(value['duration'])/60+' Minutes</b></span><br>';
                edithtml += '</div>';

                edithtml += '<div class="edit_delete" onclick="deletePoi('+value['poi'].replace("poi:", "")+')"><i class="fas fa-trash"></i></div>';

                edithtml += '<input type="hidden" class="poi-place"  value="'+value['poi'].replace("poi:", "")+'">';
                edithtml += '<input type="hidden" class="poi-duration"  value="'+value['duration']+'">';

            edithtml += '</div>';
        });

        $(".day_itinerary").html(edithtml);
        
        var saveHtml = '<button type="button" class="btn btn-success" id="save-update" onclick="savePoi('+day+')">SAVE</button>';
        $(".day_itinerary_save").html(saveHtml);
    }

    function editDuration(poi) {
        var poi_id = "poi-"+poi;
        var mins = $("#"+poi_id + ' .poi-duration').val();

        var duration = window.prompt("Input a new duration value in minutes", mins/60);
        if(duration == null){
            duration = mins/60;
        } else {
            if(!Number.isInteger(parseInt(duration))){
                duration = mins/60;
            }
        }

        $("#"+poi_id + ' .edit_duration b').html(duration + ' Minutes');
        $("#"+poi_id + ' .poi-duration').val(duration * 60);
    }

    function deletePoi(poi) {
        var item = 0;
        $("#sortable .edit_each_poi").each(function() {
            item++;
        });

        if( item > 1) {
            $("#poi-" + poi).remove();
        } else {
            alert("Sorry! At least one poi for each day.")
        }
    }

    function savePoi(day){
        if(confirm("Are you sure you want to save this itinerary ?")) {

            var item = 0;
            $("#sortable .edit_each_poi").each(function() {
                item++;
            });

            if( item > 9) {
                alert("Sorry! More then 10 attractions a day is not allowed!");
            } else {

                var update_obj = [];
                var validate_obj = [];
                var update_result = true;
                $("#sortable .edit_each_poi").each(function () {
                    var poi = $(this).find(".poi-place").val();
                    var duration = $(this).find(".poi-duration").val();

                    var obj = {};
                    obj.poi = poi;
                    obj.duration = duration;

                    //console.log(obj);
                    if (validate_obj.includes(poi)) {
                        update_result = false;
                    } else {
                        validate_obj.push(poi);
                        update_obj.push(obj);
                    }
                });

                //console.log(update_result);
                //console.log(update_obj);

                if (hotel_details != null) {
                    hotel_details = hotel_details.coordinate;
                }

                if (update_result == true) {
                    $.ajax({
                        url: '../updateItinerary',
                        async: false,
                        type: 'POST',
                        data: {
                            _token: CSRF_TOKEN,
                            id: {{$id}},
                            day: day,
                            obj: update_obj,
                            start_time: $("#day_starttime").val(),
                            end_time: "24:00",
                            hotel_details: hotel_details
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            location.reload();
                        }
                    });
                } else {
                    alert("Same attraction in a single day is not allowed!")
                }
            }
        }
    }

    function searchPoi(){
        var city = {!! json_encode($city) !!};
        var keyword = $('#keyword').val();
        
        if(keyword == '' || keyword == null){
            alert("Please enter keyword.");
        } else {
            $.ajax({
                url: '../searchAttractions',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    keyword: $('#keyword').val(),
                    city: city
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    var html = '';
                    
                    if(data.length > 0){
                        $(".not_found_msg").html();
                        $.each( data, function( key, value ) {
                            html += "<div class='edit_each_poi' id='poi-"+value['id'].substring(4)+"'>";
                                if(value['thumbnail_url'] != null){
                                    html += '<div class="edit_leftside"><img src="'+value['thumbnail_url']+'"></div>';
                                } else {
                                    html += '<div class="edit_leftside"><img src="../../images/no_image.jpg"></div>';
                                }
                                html += '<div class="edit_rightside"><span class="edit_title"><b>'+value['name']+'</b></span>';
                                html += '<br><span class="edit_duration" onclick="editDuration('+value['id'].replace("poi:", "")+')"><i class="far fa-clock"></i> <b>'+value['duration']/60+' Minutes</b></span><br>';
                                html += '</div>';
                                html += '<div class="edit_delete" onclick="deletePoi('+value['id'].replace("poi:", "")+')"><i class="fas fa-trash"></i></div>';
                                html += '<input type="hidden" class="poi-place" value="'+value['id'].replace("poi:", "")+'">';
                                html += '<input type="hidden" class="poi-duration" value="'+value['duration']+'">';
                            html += "</div>";
                        });
                        
                        $('.add_area').html(html);
                    } else {
                        $(".not_found_msg").html('<i class="fas fa-exclamation-circle"></i> Attractions not found.');
                    }
                    
                }
            });
        }
    }

    $("#keyword").on('keyup', function (e) {
        if (e.keyCode === 13) {
            searchPoi();
        }
    });

    function editView(day){

        var stay = stay_details['roomflag'][day];
        //console.log(stay);

        var html = '';
        html += '<input id="first" type="radio" name="view_start" value="1"';
        if(stay['start'] === 1){
            html += ' checked=""';
        }
        html +='>';
        html += '<label for="first"><i class="fas fa-eye"></i> Show</label>';

        html += '<input id="second" type="radio" name="view_start" value="0"';
        if(stay['start'] === 0){
            html += ' checked=""';
        }
        html +='>';
        html += '<label for="second"><i class="fas fa-eye-slash"></i> Disable</label>';

        $(".room_view .radio").html(html);



        /************* END *************/
        console.log(stay['end']);
        var html2 = '';
        html2 += '<input id="first2" type="radio" name="view_end" value="1"';
        if(stay['end'] === 1){
            html2 += ' checked=""';
        }
        html2 +='>';
        html2 += '<label for="first2"><i class="fas fa-eye"></i> Show</label>';

        html2 += '<input id="second2" type="radio" name="view_end" value="0"';
        if(stay['end'] === 0){
            html2 += ' checked=""';
        }
        html2 +='>';
        html2 += '<label for="second2"><i class="fas fa-eye-slash"></i> Disable</label>';
        console.log(html2);

        $(".room_view .radio2").html(html2);

        $(".saving_view").html('<button type="button" class="btn btn-success" id="save-view" onclick="saveView('+day+')">SAVE</button>');
    }

    function saveView(day){
        var start = $('[name="view_start"]:checked').val();
        var end = $('[name="view_end"]:checked').val();

        $.ajax({
            url: '../updateRoomView',
            async: false,
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: {{$id}},
                start: start,
                end: end,
                day: day
            },
            dataType: 'JSON',
            complete: function () {
                location.reload();
            }
        });
    }

</script>
@endsection