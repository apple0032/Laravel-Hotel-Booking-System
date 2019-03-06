@extends('main')

@section('title', '| My Flight')

@php
    use App\FlightBooking;
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
            font-family: "Noto Sans TC", sans-serif !important;
        }

        .book_container {
            margin-bottom: 40px;
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

        .seat_btn{
            text-align: center;
            font-size: 19px;
        }

        .seat_btn i{
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
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2><i class="fas fa-plane-departure"></i> 您的航班預約</h2><br>

                <input class="form-control" id="myInput" type="text" placeholder="搜尋">

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>國家/城市</th>
                            <th>出發</th>
                            <th>到達</th>
                            <th>日期</th>
                            <th>航空公司</th>
                            <th>航班</th>
                            <th>起飛</th>
                            <th>落機</th>
                            <th>需時</th>
                            <th>價錢</th>
                            <th>燃油</th>
                            <th>機位</th>
                            <th>選位</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->related_flight_id}}" data-sid="{{$bk->related_flight_id}}" style="">
                                <td><img src="https://countryflags.io/{{$bk->country_code}}/flat/32.png">　{{$bk->country}}</td>
                                <td>{{$bk->dep_airport}}</td>
                                <td>{{$bk->arr_airport}}</td>
                                <td>{{substr($bk->dep_date,0,10)}}</td>
                                <td class="airline"><img src="http://pics.avs.io/250/40/{{$bk['airline_code']}}.png">{{$bk->airline_name}}</td>
                                <td>{{$bk->flight_code}}</td>
                                <td>{{$bk->flight_start}}</td>
                                <td>{{$bk->flight_end}}</td>
                                <td>{{$bk->duration}}</td>
                                <td>$ {{$bk->price}}</td>
                                <td>$ {{$bk->tax}}</td>
                                <td>{{$bk->class}}</td>
                                <td class="seat_btn">
                                    @php
                                        $dep_time = (substr($bk->dep_date,0,10)).' '.$bk->flight_start;
                                        $dep_time = strtotime($dep_time);
                                        $current = strtotime(date("Y-m-d H:i:s"));
                                    @endphp
                                    @if($current < $dep_time)
                                        <a href="flight-seat/{{$bk->id}}"><i class="fas fa-chair"></i></a>
                                    @else
                                        <span class="disable_seat"> <i class="fas fa-times"></i></span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="book_detail bk_detail{{$bk->related_flight_id}} animated bounceInLeft faster">
                                <td colspan="13">
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
                                                    $ {{$payment['total_price']}}
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
                                                    <i class="far fa-calendar-check"></i> 到期
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
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12" style="padding-left: 30px;">
                                            @php
                                                $pass = json_decode(FlightBooking::passenger($bk->related_flight_id),true);
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
                                                            {{$m['people_name']}}
                                                        </div>
                                                        <div class="col-md-8">
                                                            {{$m['people_passport']}}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <i class="fas fa-bars"></i> 您共有 <b>{{$booking->count()}}</b> 項航班預約記錄
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

        $('.book_row').each(function () {
            $(this).on("click", function () {
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
            });
        });

    </script>
@endsection
