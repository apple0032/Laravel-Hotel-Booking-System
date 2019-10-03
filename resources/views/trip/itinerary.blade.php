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
            margin-left: 22%;
            margin-right: 22%;
            padding: 0 20px;
            margin-bottom: 150px;
            display:none;
        }
        
        .itinerary_box{
            /*margin-bottom: 20px;*/
        }
        
        .itinerary_poi{
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: solid 1px #f0eded;
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
            height: 200px;
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
    </style>

    <div class="loading_css">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> <br>
        <div class="loading_text">Generating and formatting itineraries, please wait...</div>
    </div>

    <div class="container_itinerary">
        
        <?php 
//        echo'<pre>';
//        print_r($itinerary['schedule'][0][$itinerary['dates'][0]]); 
//        echo '</pre>';
//        die();
        ?>


        @foreach($itinerary['dates'] as $i => $date)
            <div class="eachday">
                <div class="mdate">
                    {{$date}}
                </div>
                <div class="line-between-long"></div>
                @if($i == 0)
                    <div class="row itinerary_dayend">
                        <i class="fas fa-plane-arrival"></i> Arrival
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
                                        <img src="{{$poi['thumbnail_url']}}">
                                    </div>
                                    <div class="col-md-8 itinerary_details">
                                        <h3>{{$poi['location']}}</h3>
                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                        <i class="fas fa-star" style="color: #f6ab3f"></i>
                                        <br><br>
                                        {{$poi['perex']}} <br><br>
                                        <i class="fas fa-info-circle"></i> See more details
                                        <br>
                                        <span class="marker" data-toggle="modal" data-target="#iftameMarker-{{$i}}-{{$s}}">
                                            <i class="fas fa-map-marker-alt"></i> Maps
                                        </span>

                                        <div class="modal fade" id="iftameMarker-{{$i}}-{{$s}}" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <iframe src="http://maps.google.com/maps?q={{$poi['coordinate']}}&z=15&output=embed" width="100%" height="650" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

@endsection

@section('scripts')

<script>
    window.onload = function() {
        $(".container_itinerary").css("display", "block");
        $(".loading_css").hide();
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
</script>

@endsection