@extends('index')

@section('title', '| Seat')

@section('content')
    <style>
        body {
            background-image: url('') !important;
        }

        *, *:before, *:after {
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
        }

        .row {
            margin-left: 0px;
            margin-right: 0px;
        }

        .plane {
            margin: 20px auto;
            max-width: 300px;
        }

        .cockpit {
            height: 230px;
            position: relative;
            overflow: hidden;
            text-align: center;
            border-bottom: 5px solid #d8d8d8;
        }

        .cockpit:before {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 500px;
            width: 100%;
            border-radius: 50%;
            border-right: 5px solid #d8d8d8;
            border-left: 5px solid #d8d8d8;
        }

        .cockpit h1 {
            width: 60%;
            margin: 100px auto 35px auto;
        }

        .exit {
            position: relative;
            height: 50px;
        }

        .exit:before, .exit:after {
            content: "EXIT";
            font-size: 14px;
            line-height: 18px;
            padding: 0px 2px;
            font-family: "Arial Narrow", Arial, sans-serif;
            display: block;
            position: absolute;
            background: green;
            color: white;
            top: 50%;
            transform: translate(0, -50%);
            border-radius: 4px;
        }

        .exit:before {
            left: 0;
        }

        .exit:after {
            right: 0;
        }

        .fuselage {
            border-right: 15px solid #d8d8d8;
            border-left: 15px solid #d8d8d8;
            border-bottom: 1px solid #d8d8d8;
        }

        ol {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .seats {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
        }

        .seat {
            display: flex;
            flex: 0 0 14.28571428571429%;
            padding: 5px;
            position: relative;
        }

        .seat:nth-child(3) {
            margin-right: 14.28571428571429%;
        }

        .seat input[type=checkbox] {
            position: absolute;
            opacity: 0;
        }

        .seat input[type=checkbox]:checked + label {
            background: #bada55;
            -webkit-animation-name: rubberBand;
            animation-name: rubberBand;
            animation-duration: 300ms;
            animation-fill-mode: both;
        }

        .seat input[type=checkbox]:disabled + label {
            background: #dddddd;
            text-indent: -9999px;
            overflow: hidden;
        }

        .seat input[type=checkbox]:disabled + label:after {
            content: "X";
            text-indent: 0;
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translate(-50%, 0%);
        }

        .seat input[type=checkbox]:disabled + label:hover {
            box-shadow: none;
            cursor: not-allowed;
        }

        .seat label {
            display: block;
            position: relative;
            width: 100%;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5rem;
            padding: 4px 0;
            background: #F42536;
            border-radius: 5px;
            animation-duration: 300ms;
            animation-fill-mode: both;
            color: white;
        }

        .seat label:before {
            content: "";
            position: absolute;
            width: 75%;
            height: 75%;
            top: 1px;
            left: 50%;
            transform: translate(-50%, 0%);
            background: rgba(255, 255, 255, 0.4);
            border-radius: 3px;
        }

        .seat label:hover {
            cursor: pointer;
            box-shadow: 0 0 0px 2px #5C6AFF;
        }

        @-webkit-keyframes rubberBand {
            0% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
            30% {
                -webkit-transform: scale3d(1.25, 0.75, 1);
                transform: scale3d(1.25, 0.75, 1);
            }
            40% {
                -webkit-transform: scale3d(0.75, 1.25, 1);
                transform: scale3d(0.75, 1.25, 1);
            }
            50% {
                -webkit-transform: scale3d(1.15, 0.85, 1);
                transform: scale3d(1.15, 0.85, 1);
            }
            65% {
                -webkit-transform: scale3d(0.95, 1.05, 1);
                transform: scale3d(0.95, 1.05, 1);
            }
            75% {
                -webkit-transform: scale3d(1.05, 0.95, 1);
                transform: scale3d(1.05, 0.95, 1);
            }
            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
        }

        @keyframes rubberBand {
            0% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
            30% {
                -webkit-transform: scale3d(1.25, 0.75, 1);
                transform: scale3d(1.25, 0.75, 1);
            }
            40% {
                -webkit-transform: scale3d(0.75, 1.25, 1);
                transform: scale3d(0.75, 1.25, 1);
            }
            50% {
                -webkit-transform: scale3d(1.15, 0.85, 1);
                transform: scale3d(1.15, 0.85, 1);
            }
            65% {
                -webkit-transform: scale3d(0.95, 1.05, 1);
                transform: scale3d(0.95, 1.05, 1);
            }
            75% {
                -webkit-transform: scale3d(1.05, 0.95, 1);
                transform: scale3d(1.05, 0.95, 1);
            }
            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
        }

        .rubberBand {
            -webkit-animation-name: rubberBand;
            animation-name: rubberBand;
        }

        .flight_seat_map {
            margin-bottom: 60px;
            margin-right: 20%;
            margin-left: 20%;
        }

        @media (max-width: 990px) {
            .flight_seat_map {
                margin-right: 0%;
                margin-left: 0%;
            }
        }

        .flight_seat{
            border-right: 5px solid #dddddd;
        }

        .flight_seat_info{
            font-family: 'Noto Sans TC', sans-serif;
            font-size: 25px;
            padding-top: 100px;
            padding-left: 30px;
        }

        .flight_seat_body{
            margin-top: 60px;
            font-size: 16px;
        }

        .flight_seat_header img{
            width:25px;
            height: auto;
        }

        .red_notice{
            font-weight: bold;
            color: red;
        }

        .re_select{
            font-size: 22px;
            text-decoration: underline;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row flight_seat_map">
        <div class="col-md-6 flight_seat">
            <div class="plane">
                <div class="cockpit">
                    <h1>AirBus {{$booking->plane}} </h1>
                </div>
                <div class="exit exit--front fuselage"></div>
                <ol class="cabin fuselage">
                    @foreach($num_of_rows as $row)
                        <li class="row row--{{$row}}">
                            <ol class="seats" type="A">
                                @foreach($seat_each_row as $each)
                                    <li class="seat">
                                        <input type="checkbox" id="{{$row.$each}}"
                                            @php
                                                if (in_array(($row.$each), $booked_seat)){
                                                    echo 'disabled';
                                                }
                                            @endphp
                                        />
                                        <label for="{{$row.$each}}">{{$row.$each}}</label>
                                    </li>
                                @endforeach
                            </ol>
                        </li>
                    @endforeach
                </ol>
                <div class="exit exit--back fuselage"></div>
            </div>
        </div>
        <div class="col-md-6 flight_seat_info">
            <div class="flight_seat_header">
                <img src="https://img.icons8.com/ios/100/000000/flight-seat-filled.png"> 請於右方選擇航班座位
            </div>

            <div class="flight_seat_body">
                您於此航班 <span class="red_notice">{{$booking->flight_code}}</span> 已選擇的座位 -
                @if($selected_seat != null)
                    @foreach($selected_seat as $selected)
                        <span class="red_notice">{{$selected.' '}}</span>
                    @endforeach
                    @else
                        <span class="red_notice"> 沒有 </span>
                @endif
                <br><br><br>
                可供選擇的座位數目 - <span class="red_notice">{{$num_of_select}}</span> 個
                <br><br><br>
                重新選擇的座位 -　<span class="red_notice re_select"></span>
                <br><br><br>

                @if($num_of_select > 0)
                    <span class="red_notice">請慎思選擇座位，一經提交將不能更動</span>

                    {!! Form::open(array('route' => 'flight.seat_save', 'data-parsley-validate' => '')) !!}
                        <input type="hidden" name="re_select" id="re_select">
                        <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->id}}">
                        <br>
                        <button type="submit" class="btn btn-action btn-success" style="margin-top: 20px">
                            <i class="fas fa-check-circle"></i> 提交 Submit
                        </button>
                    {!! Form::close() !!}
                @else
                    <span class="red_notice">你已選擇了座位，不能更改</span>
                @endif

                <br><br><br><br><br><br>
                <a href="{{URL::to('/')}}/flight-summary" class="btn btn-primary" role="button"><i class="fas fa-undo"></i> 返回我的航班</a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var seat = [];
        var limit = '{{$num_of_select}}';
        var c = 0;
        $(".seat input[type=checkbox]").click(function () {
            console.log(c);
            if (seat.indexOf(this.id) == -1) {
                if (c < limit) {
                    seat.push(this.id);
                    c++;
                    $(this).closest('.seat').find('label').css("background", "#bada55");
                } else {
                    $(this).closest('.seat').find('label').css("background", "#F42536");
                }
            } else {
                c--;
                $(this).closest('.seat').find('label').css("background", "#F42536");
                var removeItem = this.id;
                seat.splice($.inArray(removeItem, seat), 1);
            }
            console.log(seat);

            $('.re_select').html('');
            $('#re_select').val(seat);
            for(var i=0;i<seat.length;i++) {
                jQuery('.re_select').append(seat[i]+' ');
            }
        });
    </script>
@endsection