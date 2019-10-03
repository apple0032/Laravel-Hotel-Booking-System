@php
    use App\TripAdviser;
@endphp

@extends('index')

@section('title', '| Itinerary')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <style type="text/css" class="cp-pen-styles">

        body {
            background-image: url('') !important;
            background: #f2f2f2;
            font-family: 'Quicksand', sans-serif !important;
        }

        .container_itinerary {
            margin-top: 25px;
            margin-left: 20%;
            margin-right: 20%;
            padding: 0 20px;
            margin-bottom: 70px;
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
        
        .line-between, .line-between-long{
            border-left: 2px solid #dedede;
            margin-left: 40px;
        }
        
        .line-between{
            height: 30px;
        }
        
        .line-between-long{
            height: 50px;
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
        }
        
        .itinerary_img img{
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: solid 1px #f0eded;
        }
        
        .itinerary_details{
            padding-left: 60px;
        }
        
        .itinerary_transport{
            padding-left: 45px;
        }
        
        .itinerary_transport i{
            font-size: 25px;
            margin-right: 10px;
        }
    </style>

    <div class="container_itinerary">
        
        <?php 
//        echo'<pre>';
//        print_r($itinerary['schedule'][0][$itinerary['dates'][0]]); 
//        echo '</pre>';
//        die();
        ?>
        
        @foreach($itinerary['dates'] as $i => $date)
            <div class="mdate">
                {{$date}}
            </div>
            <div class="line-between-long"></div>
            @foreach($itinerary['schedule'][$i][$date] as $poi)
                @if($poi['type'] == "poi")
                    <div class="row itinerary_box">
                        <div class="col-md-12 itinerary_poi">
                            <div class="row">
                                <div class="col-md-2 itinerary_time">
                                    {{substr($poi['schedule_time'], -8)}} <br>
                                    {{$poi['duration']/60}} Minutes
                                </div>
                                <div class="col-md-2 itinerary_img">
                                    <img src="{{$poi['thumbnail_url']}}">
                                </div>
                                <div class="col-md-8 itinerary_details">
                                    <h3>{{$poi['location']}}</h3>
                                    {{$poi['perex']}} <br>
                                    123<br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line-between"></div>
                @elseif($poi['type'] == "transport")
                    <div class="row itinerary_transport">
                        <i class="fas fa-car-side"></i> {{floor($poi['duration']/60)}} Minutes
                    </div>
                <div class="line-between"></div>
                @endif
            @endforeach
        @endforeach    
        
        
    </div>


@endsection

@section('scripts')

@endsection