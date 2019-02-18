@extends('index')

@section('title', '| Flight')

@php
    use Illuminate\Support\Facades\Input;
    use App\FlightStats;
@endphp

@section('content')
<style>
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

    .navbar{
        margin-bottom: 0px;
    }

    .flight_searchbar_row{
        padding-top: 10px;
        margin: 0px;
        background-color: #37454d;
        color: white;
    }

    .flight_searchbar_row .btn-search{
        background: #4398e9;
        width: 100%;
        color: #fff;
        box-shadow: 0 0 1.8823em 0 rgba(132, 203, 255, 0.3);
    }

    @media (max-width: 990px) {
        .flight_searchbar_row{
            padding-bottom: 20px;
        }
    }

    .flight_content_section{
        margin-top: 30px;
        font-family: 'Noto Sans TC', sans-serif;
    }

    .plane_section{
        margin-left: 10%;
        margin-right: 10%;
        margin-bottom: 100px;
    }

    .plane_title{
        font-size: 26px;
        border-bottom: 1px solid #5b5b5b;
    }

    .plane_title i{
        margin-right: 10px;
    }

    .departure_flight{
        margin-top: 20px;
    }

    @media (min-width: 990px) {
        .departure_flight{
            margin-top: 20px;
            margin-left: 10%;
            margin-right: 10%;
        }
    }

    .flight_box{
        background-color: white;
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        margin-bottom: 10px;
        padding: 20px;
        border-radius: 5px;
        transition: 0.2s all;
    }

    .flight_box:hover{
        box-shadow: 0 1px 4px rgba(10, 40, 58, 1);
    }

    .flight_box_header{
        font-size: 18px;
        padding-bottom: 15px;
        cursor: pointer;
    }

    .select_btn{
        font-family: 'Noto Sans TC', sans-serif;
        border: 1px solid black;
        border-radius: 4px;
        padding: 5px;
        transition: 0.2s all;
        cursor: pointer;
    }

    .select_btn:hover{
        background-color: #37454d;
        color: white;
        border: none;
    }

    @media (max-width: 990px) {
        .select_btn_col {
            margin-top: 15px;
        }
    }

    .select_btn_col i{
        float: right;
    }

    .gws-flights-results__dotted-flight-icon{
        background: url(//www.gstatic.com/flights/app/1x/dotted_flight_80dp.png) no-repeat 0 5px;
        height: 85px;
        left: 68px;
        width: 12px;
        display: inline-block;
    }

    .flight_box_details{
        margin-left: 10%;
        padding-top: 20px;
        padding-right: 50px;
        border-top: 1px solid #aaaaaa;
    }

    .flight_info{
        display: inline-block;
        height: 85px;
        vertical-align: top;
        font-size: 16px;
    }

    .flight_info_attr{
        margin-left: 5px;
    }

    @media (max-width: 990px) {
        .flight_box_details{
            margin-bottom: 100px;
        }
    }

    .flight_info_equi{
        font-size: 14px;
        margin-top: 20px;
    }
    
    .arrival_section{
        display: none;
    }

    .arrival_title{
        display: inline-block;
        float: right;
    }

    .selected_dep_flight{
        font-size: 18px;
        display: inline-block;
        background-color: rgba(255, 43, 29, 0.84);
        color: white;
        border-radius: 5px;
        padding: 5px;
        cursor: pointer;
    }

    @media (max-width: 990px) {
        .arrival_section .plane_title{
            margin-bottom: 100px;
        }
    }

    .reselect_dep{
        font-size: 22px;
        color: rgba(255, 43, 29, 0.84);
        margin-left: 4px;
        cursor: pointer;
    }


</style>

<meta name="csrf-token" content="{{ csrf_token() }}"/>

<div class="flight_searchbar">
    {!! Form::open(array('route' => 'flight.search', 'data-parsley-validate' => '')) !!}
    <div class="row flight_searchbar_row">
        <div class="col-md-2">
            <label name="subject">國家 Country</label>
            <input id="country" name="country" class="form-control" type="text" maxlength="30">
            <ul class="list-unstyled"></ul>
        </div>
        <div class="col-md-2">
            <label name="subject">國家代碼 Country Code</label>
            <input id="countrycode" name="countrycode" class="form-control" type="text" maxlength="30" readonly>
        </div>
        <div class="col-md-2">
            <label name="subject">出發機場 Departure Airport</label>
            <select id="departure_airport" name="departure_airport" class="form-control">
                <option value="HKG">Hong Kong International Airport</option>
            </select>
        </div>
        <div class="col-md-2">
            <label name="subject">到達機場 Arrival Airport</label>
            <select id="airport" name="airport" class="form-control">
                @if($airports != null)
                    @foreach($airports as $airport)
                        @if( (Input::get('to')) == $airport['code'])
                            <option value="{{$airport['code']}}" selected>{{$airport['name']}}</option>
                        @else
                            <option value="{{$airport['code']}}">{{$airport['name']}}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-3">
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
            <button type="submit" class="btn btn-action btn-search" style="margin-top: 20px">
                <i class="fab fa-searchengin"></i> SEARCH
            </button>
        </div>
    </div>

    {!! Form::close() !!}
</div>


<!-- Flight Search main content -->


<div class="flight_content_section">
    <div class="departure_section plane_section">
        <div class="plane_title">
            <i class="fas fa-plane-departure"></i> 選擇由 香港 HKG 飛往 {{Input::get('country')}} 的航班
        </div>

        <input type="hidden" name="selected_dep_flight" id="selected_dep_flight" value="">

        <div class="departure_flight">
            @if($departure != null)
                @foreach($departure as $k => $dep)
                    <div class="flight_box">
                        <div class="flight_box_header" data-toggle="collapse" data-target="#coll-{{$dep['flightNumber']}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="http://pics.avs.io/250/40/{{$dep['carrierFsCode']}}.png">
                                </div>
                                <div class="col-md-3">
                                    {{FlightStats::AirlinesData($dep['carrierFsCode'])}}
                                </div>
                                <div class="col-md-1">
                                    {{$dep['carrierFsCode'].$dep['flightNumber']}}
                                </div>

                                <div class="col-md-3">
                                    出發  <i class="fas fa-plane"></i> &nbsp;&nbsp; {{str_replace('.000','',str_replace("T"," ",$dep['departureTime']))}}
                                </div>
                                <div class="col-md-2 select_btn_col">
                                    <span class="select_btn" onclick="clickDeparture('{{$dep['carrierFsCode']}}','{{$dep['flightNumber']}}')">選擇此航班</span>
                                    <i class="fas fa-angle-double-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flight_box_details collapse" id="coll-{{$dep['flightNumber']}}">
                            <div class="gws-flights-results__dotted-flight-icon"></div>
                            <div class="flight_info">
                                <div class="flight_info_attr">
                                    出發 <i class="fas fa-plane-departure"></i>
                                    {{str_replace('.000','',str_replace("T"," ",$dep['departureTime']))}} &nbsp;&nbsp;&nbsp;
                                    <i class="fas fa-city"></i>
                                    由 {{Input::get('from')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('from'));
                                        print_r('('.$from[0]['name'].')');
                                    @endphp
                                </div>
                                <br><br>
                                <div class="flight_info_attr">
                                    到達 <i class="fas fa-plane-arrival"></i>
                                    {{str_replace('.000','',str_replace("T"," ",$dep['arrivalTime']))}} &nbsp;&nbsp;&nbsp;
                                    <i class="fas fa-city"></i>
                                    到 {{Input::get('to')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('to'));
                                        print_r('('.$from[0]['name'].')');
                                    @endphp
                                </div>
                            </div>
                            <div class="flight_info_equi">
                                <i class="fas fa-fighter-jet"></i> 飛機型號 - {{$dep['flightEquipmentIataCode']}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="arrival_section plane_section">
        <div class="plane_title">
            <i class="fas fa-plane-departure"></i>
            <div class="selected_dep_flight"></div>
            <span class="reselect_dep"><i class="fas fa-arrow-circle-left"></i></span>

            <div class="arrival_title">選擇由 {{Input::get('country')}} 飛往 香港 HKG 的航班
                <i class="fas fa-plane-arrival" style="transform: scaleX(-1);"></i>
            </div>
        </div>

        <input type="hidden" name="selected_arr_flight" id="selected_arr_flight" value="">

        <div class="departure_flight">
            @if($departure != null)
                @foreach($arrival as $k => $arr)
                    <div class="flight_box">
                        <div class="flight_box_header" data-toggle="collapse" data-target="#coll-{{$arr['flightNumber']}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="http://pics.avs.io/250/40/{{$arr['carrierFsCode']}}.png">
                                </div>
                                <div class="col-md-3">
                                    {{FlightStats::AirlinesData($arr['carrierFsCode'])}}
                                </div>
                                <div class="col-md-1">
                                    {{$arr['carrierFsCode'].$arr['flightNumber']}}
                                </div>

                                <div class="col-md-3">
                                    出發  <i class="fas fa-plane"></i> &nbsp;&nbsp; {{str_replace('.000','',str_replace("T"," ",$arr['departureTime']))}}
                                </div>
                                <div class="col-md-2 select_btn_col">
                                    <span class="select_btn" onclick="clickArrival('{{$arr['carrierFsCode']}}','{{$arr['flightNumber']}}')">選擇此航班</span>
                                    <i class="fas fa-angle-double-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flight_box_details collapse" id="coll-{{$arr['flightNumber']}}">
                            <div class="gws-flights-results__dotted-flight-icon"></div>
                            <div class="flight_info">
                                <div class="flight_info_attr">
                                    出發 <i class="fas fa-plane-departure"></i>
                                    {{str_replace('.000','',str_replace("T"," ",$arr['departureTime']))}} &nbsp;&nbsp;&nbsp;
                                    <i class="fas fa-city"></i>
                                    由 {{Input::get('from')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('to'));
                                        print_r('('.$from[0]['name'].')');
                                    @endphp
                                </div>
                                <br><br>
                                <div class="flight_info_attr">
                                    到達 <i class="fas fa-plane-arrival"></i>
                                    {{str_replace('.000','',str_replace("T"," ",$dep['arrivalTime']))}} &nbsp;&nbsp;&nbsp;
                                    <i class="fas fa-city"></i>
                                    到 {{Input::get('to')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('from'));
                                        print_r('('.$from[0]['name'].')');
                                    @endphp
                                </div>
                            </div>
                            <div class="flight_info_equi">
                                <i class="fas fa-fighter-jet"></i> 飛機型號 - {{$arr['flightEquipmentIataCode']}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>






@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    //Init value to searchbar
    $("#country").val('{{Input::get('country')}}');
    $("#countrycode").val('{{Input::get('code')}}');
    var daterange = '{{Input::get('start')}} - {{Input::get('end')}}';
    setTimeout(function(){ $("#daterange").val(daterange); }, 1000);
</script>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            locale:{
                format: 'YYYY-MM-DD'
            },
            minDate: new Date(),
            //startDate: '01/13/2019',
            showDropdowns: true,
            autoApply: true
        }, function(start, end, label) {
            console.log("A date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
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
                    url: 'searchcountry',
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
                                var code = $(this).find('.list-code').val();
                                console.log(code);
                                $('#countrycode').val(code);
                                GetAirports(code,CSRF_TOKEN); //Trigger get airport api
                            });
                        });
                    }
                });

            }, doneTypingInterval);
        }
    });

    function GetAirports(code,token){

        //Ajax call api
        $.ajax({
            url: 'searchairport',
            async: false,
            type: 'POST',
            data: {
                _token: token,
                code: code
            },
            dataType: 'JSON',
            beforeSend: function () {
                $('#airport').html("");
            },
            success: function (data) {
                //<option value="HKG">Hong Kong International Airport</option>

                $.each( data, function( key, value ) {
                    $('#airport').append('<option value="'+value['code']+'">'+value['name']+'</option>');
                });
            }
        });


    }


    $("#country").focus(function () {
        $("#country").trigger("keyup");
    });

    $("#country").blur(function () {
        $(".list-unstyled").fadeOut();
    });

</script>


<script>
    function clickDeparture(fs,fno) {
        //alert(fs); alert(fno);
        $('#selected_dep_flight').val(fs+fno);
        $('.selected_dep_flight').html('出發 - '+fs+fno);
        $('.departure_section').fadeOut();
        $('.arrival_section').fadeIn();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }

    function clickArrival(fs,fno) {
        alert(fs); alert(fno);
        $('#selected_arr_flight').val(fs+fno);
    }

    $('.reselect_dep, .selected_dep_flight').click(function () {
        $('.arrival_section').fadeOut();
        $('.departure_section').fadeIn();
        $('#selected_dep_flight').val('');
        $('.selected_dep_flight').html('');
        $("html, body").animate({ scrollTop: 0 }, "slow");
    })

    $('.flight_box_header').hover(function () {
        //$(this).click();
    })
</script>




@endsection