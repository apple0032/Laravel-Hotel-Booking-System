@extends('main')

@section('title', '| Booking')
@php
    use App\Trip;
@endphp
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <style>
        body {
            font-family: "Noto Sans TC", sans-serif !important;
        }

        .book_container {
            margin-bottom: 40px;
        }

        .book_row {
            cursor: pointer;
        }

        .book_detail {
            display: none;
        }

        .book_detail_col {
            border-right: 1px solid #2d6098;
        }

        .hotel_name {
            font-weight: bold;
            font-size: 17px;
        }

        .book_detail_room {
            font-size: 16px;
        }

        .book_detail_room div {
            margin-bottom: 10px;
        }

        .book_detail_guest {
            font-size: 16px;
        }

        .guest_email {
            text-overflow: ellipsis;
            max-width: 150px;
            overflow: hidden !important;
            white-space: nowrap;
        }

        .table_header{
            background-color: #2d6098;
            color: white;
        }

        @media (min-width: 768px) {
            .modal-dialog {
                width: 1000px;
                margin: 30px auto;
            }
        }

        .flight_searchbar{
            padding-right: 50px;
            padding-left: 50px;
            padding-bottom: 50px;
        }

        .flight_header{
            font-size: 20px;
            margin-bottom: 20px;
        }

        .list-unstyled {
            position: absolute;
            z-index: 10;
            background-color: white;
            display: none;
            margin-top: -7px;
            border: 1px solid #b4b4b4;
            padding:7px;
        }

        .list-unstyled li {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
            border-radius: 2px;
            color: #0b1a27;
            font-size: 21px;
        }

        .list-unstyled li:hover {
            background-color: #dddddd;
            font-weight: bold;
        }

        .btn_trip{
            display: none;
        }

        .trip_trigger{
            text-align: center;
        }

        .trip_trigger i{
            font-size: 20px;
        }

        .booked_flight{
            color: white;
            background-color: red;
            border-radius: 5px;
            padding: 5px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2>您的酒店預約</h2><br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                    <input class="form-control" id="myInput" type="text" placeholder="搜尋">
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>預訂ID</th>
                            <th>酒店</th>
                            <th>酒店房間</th>
                            <th>人數</th>
                            <th>入住日期</th>
                            <th>退房日期</th>
                            <th>預約時間</th>
                            <th>總價錢</th>
                            <th>狀態</th>
                            <th>預訂機票</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->id}}" data-sid="{{$bk->id}}" style="
                                @php
                                    if($bk->id == $bkhotel){
                                        echo 'background-color: rgb(244, 207, 207)';
                                    }
                                @endphp
                            ">
                                <td>{{$bk->id}}</td>
                                <td>{{$bk->hotel['name']}}</td>
                                <td>{{$room_type[$key]}}</td>
                                <td>{{$bk->people}} 人</td>
                                <td>{{substr($bk->in_date, 0,10)}}</td>
                                <td>{{substr($bk->out_date, 0,10)}}</td>
                                <td>{{$bk->book_date}}</td>
                                <td>$ {{$bk->total_price}}</td>
                                <td>@if($bk->status == 1) 正常 @endif</td>
                                <td class="trip_trigger">
                                    @if(Trip::getTrip($bk->id) == false)
                                        <a href="booklist?bkhotel={{$bk->id}}"><i class="fas fa-plane"></i></a>
                                    @else
                                        <a href="{{URL::to('/')}}/trip"><span class="booked_flight">已預訂</span></a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="book_detail bk_detail{{$bk->id}} animated bounceInDown faster">
                                <td colspan="10">
                                    <div class="row well" style="margin: 0px">
                                        <div class="col-md-4 col-sm-12 book_detail_col">

                                            @if($bk['hotel']['image'] != 'null.jpg')
                                                <img src="{{url('/')}}/images/upload/{{$bk['hotel']['image']}}"
                                                     class="img-responsive">
                                            @else
                                                <img src="http://photo.hotellook.com/image_v2/limit/h{{$bk['hotel']['default_image']}}_0/640/480.jpg"
                                                     class="img-responsive">
                                            @endif
                                            <div class="hotel_name">
                                                <a href="{{url('/')}}/hotel/{{$bk['hotel']['id']}}"> {{$bk->hotel['name']}}
                                                    <br> </a>
                                                <?php for ($x = 0; $x < $bk['hotel']['star']; $x++) { ?>
                                                <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <div class="col-md-4 col-sm-12 book_detail_col">
                                            <div class="row book_detail_room">
                                                <div class="col-md-6">
                                                    房間種類
                                                </div>
                                                <div class="col-md-6">
                                                    {{$room_type[$key]}}
                                                </div>
                                                <div class="col-md-6">
                                                    每晚收費
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['single_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    預訂手續費
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['handling_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    入住日數
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                    $date1 = date_create($bk->in_date);
                                                    $date2 = date_create($bk->out_date);
                                                    $diff = date_diff($date1, $date2);
                                                    echo $diff->format("%a 日");
                                                    ?>
                                                </div>
                                                <div class="col-md-6">
                                                    總價錢
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['total_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    付款方式
                                                </div>
                                                <div class="col-md-6">
                                                    @if($bk->payment['payment_method_id'] == 5)
                                                        入住到付
                                                    @else
                                                        {{$pay_method[$key]}}
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    付款狀態
                                                </div>
                                                <div class="col-md-6">
                                                    @if($bk->payment['status'] == 1)
                                                        <span style="color:#53c667">成功</span>
                                                    @else
                                                        <span style="color:red">未完成</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="row book_detail_guest">
                                                <div class="col-md-1">
                                                    &nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                    名稱
                                                </div>
                                                <div class="col-md-3">
                                                    電話
                                                </div>
                                                <div class="col-md-5">
                                                    電郵
                                                </div>
                                            </div>
                                            @foreach($bk->guest as $guest)
                                                <div class="row book_detail_guest">
                                                    <div class="col-md-1">
                                                        <i class="fas fa-male"></i>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$guest->name}}
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if($guest->phone != '0')
                                                            {{$guest->phone}}
                                                        @else
                                                            /
                                                        @endif
                                                    </div>
                                                    <div class="col-md-5 guest_email">
                                                        @if($guest->email != '')
                                                            {{$guest->email}}
                                                        @else
                                                            /
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        {{--<tr>--}}
                        {{--<td colspan="9">Sum: $180</td>--}}
                        {{--</tr>--}}

                        </tbody>
                    </table>
                </div>

                <i class="fas fa-hotel"></i> 您共有 <b>{{$booking->count()}}</b> 項酒店預約
            </div>


            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg btn_trip" data-toggle="modal" data-target="#myModal">Open Modal</button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">
                                <i class="fas fa-check-circle"></i> Successful ! 您已成功預訂酒店 ! 接下來距離您的旅程只差一步
                            </h3>
                        </div>
                        <div class="modal-body">

                            <div class="flight_searchbar">
                                {!! Form::open(array('route' => 'flight.search', 'id' => 'flight-search-form', 'data-parsley-validate' => '')) !!}
                                <div class="row flight_searchbar_row">

                                    <div class="flight_header">
                                        <i class="fas fa-plane"></i> 請選擇國家以完成您的旅程
                                    </div>

                                    <div class="col-md-12">
                                        <label name="subject">國家 Country</label>
                                        <input id="country" name="country" class="form-control" type="text" maxlength="30" autocomplete="off">
                                        <ul class="list-unstyled"></ul>
                                    </div>
                                    <div class="col-md-12">
                                        <label name="subject">國家代碼 Country Code</label>
                                        <input id="countrycode" name="countrycode" class="form-control" type="text" maxlength="30" readonly>
                                    </div>
                                    <div class="col-md-12">
                                        <label name="subject">城市 City</label>
                                        <select id="city" name="city" class="form-control"></select>
                                    </div>
                                    <input type="hidden" id="trip" name="trip_id" value="{{$bkhotel}}">
                                    <div class="col-md-4" style="display: none">
                                        <label name="subject">Departure Airport:</label>
                                        <select id="departure_airport" name="departure_airport" class="form-control">
                                            <option value="HKG">Hong Kong International Airport</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label name="subject">到達機場 Arrival Airport</label>
                                        <select id="airport" name="airport" class="form-control">

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label name="subject">出發/回程日期 Departure & Arrival Date</label>
                                        <div class="form-group">
                                            <div class="input-group date" id="datetimepicker">
                                                <input class="form-control" type="text" name="daterange" id="daterange" value="" readonly/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon-calendar glyphicon"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-action btn-search btn-primary" style="margin-top: 20px">
                                            <i class="fab fa-searchengin"></i> SEARCH
                                        </button>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
    <script>

        var bkhotel = '{{$bkhotel}}';
        if(bkhotel != ''){
            $('.btn_trip').click();
            $('#daterange').val('{{$range}}');
        }

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

    <script>

        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 350;  //time in ms

        //on keyup, start the countdown
        $('#country').keyup(function(){

            var keyword = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            clearTimeout(typingTimer);
            if ($('#country').val) {
                typingTimer = setTimeout(function(){

                    $.ajax({
                        url: '../searchcountry',
                        async: false,
                        type: 'POST',
                        data: {
                            _token: CSRF_TOKEN,
                            name: keyword,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                            $(".list-unstyled").html('');
                            console.log('ajax start');
                        },
                        success: function (data) {
                            //console.log(data);
                            if(data['status'] == 'success'){
                                $.each( data['country'], function( key, value ) {
                                    if(key>5){ return false; };
                                    $('.list-unstyled').append('' +
                                        '<li class="search_opt">' +
                                        '<div class="row">' +
                                        '<div class="col-md-12">' +
                                        data['country'][key]["name"] +
                                        '</div>' +
                                        '</div><input type="hidden" class="list-code" id="c-'+data['country'][key]["name"]+'" name="code" value="'+data['country'][key]["alpha2Code"]+'"></li>');
                                });

                                $(".list-unstyled").fadeIn();
                            } else {
                                $(".list-unstyled").fadeOut();
                                $('#countrycode').val('');
                                $('#airport').html('');
                            }

                            $(".search_opt").each(function (index) {
                                $(this).on("click", function () {
                                    var name = $(this).text();
                                    $("#country").val(name);
                                    var code = $(this).find('.list-code').val();
                                    console.log(code);
                                    $('#countrycode').val(code);
                                    GetCities(code,CSRF_TOKEN); //Trigger get airport api
                                });
                            });
                        }
                    });

                }, doneTypingInterval);
            }
        });

        function GetCities(code,token){

            //Ajax call api
            $.ajax({
                url: '../searchairport',
                async: false,
                type: 'POST',
                data: {
                    _token: token,
                    code: code
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $('#city').html("");
                },
                success: function (data) {
                    //<option value="HKG">Hong Kong International Airport</option>

                    $.each( data, function( key, value ) {
                        $('#city').append('<option value="'+value+'">'+value+'</option>');
                    });
                    
                    getAirports(data[0]);
                }
            });
        }

        $("#city").change(function(){
            getAirports($(this).val());
        });

        function getAirports(city){
            //alert(city);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            //Ajax call api
            $.ajax({
                url: '../getairportlist',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    city: city
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $('#airport').html("");
                },
                success: function (data) {
                    //<option value="HKG">Hong Kong International Airport</option>
                    $.each( data, function( key, value ) {
                        $('#airport').append('<option value="'+value['iata_code']+'">'+value['name']+'</option>');
                    });
                }
            });
        }

        $("#country").focus(function () {
            $("#country").trigger("enterKey");
        });

        $("#country").blur(function () {
            $(".list-unstyled").fadeOut();
        });

        //Disable search form submit by `Enter` key
        $('#flight-search-form').keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    
    </script>

@endsection
