@extends('main')

@section('title', '| My Flight')

@php
    use App\FlightBooking;
    use App\FlightPassenger;
@endphp

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <style>
        #myTable{
            font-weight: bold;
        }

        @media (min-width: 1200px) {
            .container {
                width: 1500px;
            }
        }

        body {
            font-family: 'Quicksand', sans-serif !important;
        }

        .book_container {
            margin-bottom: 120px;
        }

        .book_row {
            cursor: pointer;
        }

        .book_row:hover{
            border-bottom: 2px solid #7a878f;
            border-radius: 5px;
        }

        .book_detail {
            display: none;
        }

        .book_detail_col {
            border-right: 1px solid #2d6098;
            padding-right: 30px;
            font-size: 16px;
        }

        @media (min-width: 986px) {
            .book_detail_col {
                min-height: 185px;
            }
        }

        .book_detail_room div {
            margin-bottom: 10px;
        }

        .table_header{
            background-color: rgb(166, 86, 86);
            color: white;
        }
        
        .det_header{
            font-size:16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #2d6098;
            padding-bottom: 10px;
        }
        
        .det_header i{
            font-size: 18px;
            margin-right: 10px;
        }

        .airline img{
            zoom: 0.6;
            margin-right: 30px;
            margin-left: 30px;
        }

        .option_btn{
            text-align: center;
            font-size: 19px;
        }

        .option_btn i{
            border: 1px solid #2d6098;
            padding: 5px 7px;
            border-radius: 2px;
            color: white;
            background-color: #2d6098;
        }

        .det_col i{
            font-size: 16px;
            margin-right: 20px;
        }

        .paid{
            background-color: #58ff58;
            padding: 0px 5px;
            border-radius: 5px;
        }

        .no_paid{
            background-color: #ff8c89;
            padding: 0px 5px;
            border-radius: 5px;
        }

        .disable_seat i{
            background-color: red;
            color: #ffffff;
            border: 0;
            cursor: auto;
        }
        
        .option_btn .fa-umbrella-beach{
            background: #585858;
            border: 0;
        }

        .total_pass{
            margin-top: 30px;
            padding-left: 10px;
        }

        .red_notice{
            font-weight: bold;
            color: red;
        }

        .seat_detail i{
            margin-right: 20px;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2><i class="fas fa-plane-departure"></i> Flight Booking</h2><br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                    <input class="form-control" id="myInput" type="text" placeholder="Search">
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Departure Airport</th>
                            <th>Arrival Airport</th>
                            <th>Date</th>
                            <th>Airlines</th>
                            <th>Flight</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Time</th>
                            <th>Price</th>
                            <th>Fuel</th>
                            <th>Seat</th>
                            <th>Choose</th>
                            <th>Trip</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->related_flight_id}}" data-sid="{{$bk->related_flight_id}}" style="">
                                <td style="width: 160px;"><img src="https://countryflags.io/{{$bk->country_code}}/flat/32.png">　{{$bk->country}}</td>
                                <td style="width: 160px;"><img src="https://countryflags.io/{{$bk->arr_country_code}}/flat/32.png">　{{$bk->arr_country}}</td>
                                <td>{{$bk->dep_airport}}</td>
                                <td>{{$bk->arr_airport}}</td>
                                <td style="width: 100px;">{{substr($bk->dep_date,0,10)}}</td>
                                <td class="airline"><img src="http://pics.avs.io/250/40/{{$bk['airline_code']}}.png"><br><div style="text-align: center">{{$bk->airline_name}}</div></td>
                                <td>{{$bk->flight_code}}</td>
                                <td>{{$bk->flight_start}}</td>
                                <td>{{$bk->flight_end}}</td>
                                <td>{{$bk->duration}}</td>
                                <td>$ {{$bk->price}}</td>
                                <td>$ {{$bk->tax}}</td>
                                <td>{{$bk->class}}</td>
                                <td class="option_btn">
                                    @php
                                        $dep_time = (substr($bk->dep_date,0,10)).' '.$bk->flight_start;
                                        $dep_time = strtotime($dep_time);
                                        $current = strtotime(date("Y-m-d H:i:s"));

                                        $passenger = FlightPassenger::where('flight_booking_id','=',$bk->id)->get()->toArray();
                                        $selected_seat = FlightBooking::flightSelectedSeat($passenger);
                                        $num_of_select = FlightBooking::flightSeatAvailableSelect($passenger);
                                    @endphp
                                    @if(($current < $dep_time) && $num_of_select != 0)
                                        <a href="flight-seat/{{$bk->id}}"><i class="fas fa-chair"></i></a>
                                    @else
                                        <span class="disable_seat"> <i class="fas fa-times"></i></span>
                                    @endif
                                </td>
                                <td class="option_btn">
                                    <a href="trip/plan?f={{$bk->related_flight_id}}"><i class="fas fa-umbrella-beach"></i></a>
                                </td>
                            </tr>
                            <tr class="book_detail bk_detail{{$bk->related_flight_id}} animated bounceInLeft faster">
                                <td colspan="14">
                                    <div class="row well" style="margin: 0px">
                                        <div class="col-md-4 col-sm-12 book_detail_col">
                                            @php
                                                $payment = json_decode(FlightBooking::payment($bk->related_flight_id),true);
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-12 det_header">
                                                    <i class="fas fa-file-invoice-dollar"></i> PAYMENT
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="fas fa-signal"></i> 狀態
                                                </div>
                                                <div class="col-md-8">
                                                    @if($payment['status'] == 1)
                                                        <span class="paid">已付款</span>
                                                    @else
                                                        <span class="no_paid">未付款</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="fas fa-hand-holding-usd"></i> 費用
                                                </div>
                                                <div class="col-md-8">
                                                    <span class="red_notice">$ {{$payment['total_price']}} </span>
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="far fa-credit-card"></i> 方式
                                                </div>
                                                <div class="col-md-8">
                                                    @php 
                                                        if(isset($payment['payment_method'])){
                                                            print_r($pay_method_list[$payment['payment_method']]); 
                                                        }
                                                    @endphp
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="fas fa-barcode"></i> 卡號
                                                </div>
                                                <div class="col-md-8">
                                                    {{$payment['card_number']}}&nbsp;
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="fas fa-shield-alt"></i> 安全碼
                                                </div>
                                                <div class="col-md-8">
                                                    {{$payment['security_number']}}&nbsp;
                                                </div>
                                                <div class="col-md-4 det_col">
                                                    <i class="far fa-calendar-check"></i> 到期日
                                                </div>
                                                <div class="col-md-8">
                                                    {{$payment['expired_date']}}&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 book_detail_col" style="padding-left: 30px;">
                                            <div class="row">
                                                <div class="col-md-12 det_header">
                                                    <i class="fas fa-chair"></i> SEAT PLAN
                                                </div>
                                                <div class="col-md-12 seat_detail">
                                                    <i class="fas fa-plane"></i> 飛機型號 : AirBus {{$bk->plane}} <br>
                                                    <i class="fas fa-check-square"></i> 已選擇座位數目： <span class="red_notice"> {{count($selected_seat)}}</span> <br>
                                                    <i class="fas fa-cat"></i> 已選擇座位:
                                                    @if($selected_seat != null)
                                                        @foreach($selected_seat as $selected)
                                                            <span class="red_notice">{{$selected.' '}}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="red_notice"> 沒有 </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12" style="padding-left: 30px;">
                                            @php
                                                $pass = json_decode(FlightBooking::passenger($bk->id),true);
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-12 det_header">
                                                    <i class="fas fa-user"></i> PASSENGER
                                                </div>
                                                <div class="col-md-4" style="text-transform: capitalize;">
                                                    <i class="fas fa-male"></i>&nbsp;&nbsp; 乘客
                                                </div>
                                                <div class="col-md-8">
                                                    <i class="fas fa-passport"></i>&nbsp;&nbsp; 護照號碼
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 5px">
                                                @if($pass != null)
                                                    @foreach($pass as $k => $m)
                                                        <div class="col-md-4">
                                                            <span class="red_notice"> {{$m['people_name']}} </span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="red_notice"> {{$m['people_passport']}} </span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="row total_pass">
                                                <i class="fas fa-parachute-box"></i> 此航班共有 {{count($pass)}} 位乘客
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <i class="fas fa-bars"></i> You have total <b>{{$booking->count()}}</b> flight booking record.
            </div>


        </div>
    </div>

    <input type="hidden" name="sbg" id="sbg">

    <script>

        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr:not('.book_detail')").filter(function () {
                $('.book_detail').fadeOut();
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $(".dropdown").click(function () {
            $(".dropdown").addClass('open');
        });
        
        var option = false;
        $(".option_btn").click(function () {
            option = true;
        });

        $('.book_row').each(function () {
            $(this).on("click", function () {
                if(option == false){
                    var sid = $(this).data('sid');
                    var sbg = $('#sbg').val();
                    if(sbg != sid) {
                        $('.book_'+sid).css("background-color", "#f4cfcf");
                        $('.book_'+sbg).css("background-color", "white");
                        $('#sbg').val(sid);
                    }

                    if ($('.bk_detail' + sid).hasClass("act") == false) {

                        $('.bk_detail' + sid).fadeIn();
                        $('.bk_detail' + sid).addClass('act');

                        $('.book_detail:not(.bk_detail' + sid + ')').hide();
                        $('.book_detail:not(.bk_detail' + sid + ')').removeClass('act');
                    } else {
                        $('.bk_detail' + sid).fadeOut();
                        $('.bk_detail' + sid).removeClass('act');
                    }
                }
            });
        });

    </script>
@endsection
