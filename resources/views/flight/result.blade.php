@extends('index')

@section('title', '| Flight Results')

@php
    use Illuminate\Support\Facades\Input;
    use App\FlightStats;
@endphp

@section('content')
<style>
    body{
        background-image: url('') !important;
    }

    /* vietnamese */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        src: local('Quicksand Regular'), local('Quicksand-Regular'), url(https://fonts.gstatic.com/s/quicksand/v9/6xKtdSZaM9iE8KbpRA_hJFQNcOM.woff2) format('woff2');
        unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
    }
    /* latin-ext */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        src: local('Quicksand Regular'), local('Quicksand-Regular'), url(https://fonts.gstatic.com/s/quicksand/v9/6xKtdSZaM9iE8KbpRA_hJVQNcOM.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        src: local('Quicksand Regular'), local('Quicksand-Regular'), url(https://fonts.gstatic.com/s/quicksand/v9/6xKtdSZaM9iE8KbpRA_hK1QN.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Libre Baskerville';
        font-style: normal;
        font-weight: 400;
        src: local('Libre Baskerville'), local('LibreBaskerville-Regular'), url(https://fonts.gstatic.com/s/librebaskerville/v6/kmKnZrc3Hgbbcjq75U4uslyuy4kn0qNXaxMICA.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
        font-family: 'Libre Baskerville';
        font-style: normal;
        font-weight: 400;
        src: local('Libre Baskerville'), local('LibreBaskerville-Regular'), url(https://fonts.gstatic.com/s/librebaskerville/v6/kmKnZrc3Hgbbcjq75U4uslyuy4kn0qNZaxM.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
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

    .btn-submit{
        background: rgba(6, 94, 147, 0.54);
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
        margin-left: 5%;
        margin-right: 5%;
        margin-bottom: 100px;
    }

    .plane_title{
        font-size: 20px;
        border-bottom: 1px solid #afafaf;
        background-color: #ededed;
        font-family: 'Noto Sans TC', sans-serif;
        padding-right: 10%;
        padding-left: 10%;
        padding-top: 5px;
        padding-bottom: 5px;
        transition: 0.4s all;
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


    .flight_box_skip{
        background-color: #3b6da3;
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        margin-bottom: 10px;
        padding: 20px;
        border-radius: 5px;
        transition: 0.2s all;
        color:white;
    }

    .flight_box_skip:hover{
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
        .flight_info_mobile{
            margin-top: 80px;
        }
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
    
    .arrival_section, .booking_section{
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

    .selected_arr_flight{
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

    .reselect_dep, .reselect_arr{
        font-size: 22px;
        color: rgba(255, 43, 29, 0.84);
        margin-left: 4px;
        cursor: pointer;
    }

    .arr_i{
        transform: scaleX(-1);
        margin-left: 10px
    }

    .arr_bk_i{
        margin-right: 0px !important;
    }

    .reselect_arr{
        margin-right: 5px;
    }
    
    .reselect_arr i{
        transform: scaleX(-1);
    }

    .title_selected{
        display: none;
    }

    .plane_title_arrival{
        display: inline-block;
        float: right;
    }

    .dep_title_selected{
        display: inline-block;
    }

    .arrival_title_selected{
        display: none;
    }

    .plane_title img{
        width:35px;
    }

    .flight_price{
        color: #58a126;
        font-size: 30px;
        font-weight: bold;
        text-align: center;
        font-family: 'Quicksand', sans-serif;
    }

    .fly_detail{
        font-size: 13px;
        font-weight: bold;
        margin-right: 60px;
    }

    .no_result {
        text-align: center;
        color: #0b1a27;
        border-radius: 3px;
        padding: 15px 15px 30px 15px;
        margin-top: 10px;
        font-size: 22px;
        font-family: 'Noto Sans TC', sans-serif !important;
        background-color: white;
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
    }

    .no_result i {
        font-size: 80px;
        display: block;
        margin-bottom: 15px;
    }

    .no_result span {
        font-family: 'Kanit', sans-serif;
    }

    #no_result_close {
        float: right !important;
        color: #37454d;
        text-align: right;
    }

    #no_result_close i {
        font-size: 23px;
        cursor: pointer;
    }

    .flight_class{
        font-size: 12px;
    }

    .flight_time{
        font-size: 15px;
    }

    .flight_airline{
        font-weight: bold;
        padding-right: 0px;
        padding-left: 0px;
        font-family: 'Libre Baskerville', serif;
        text-align: left;
    }

    @media (max-width: 990px) {
        .flight_airline{
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }
    }

    .flight_number{
        font-size: 14px;
    }

    .booking_section .add_new_person{
        line-height: 20px;
        height: 20px;
        padding: 0 20px;
    }

    .booking_section{
        background-color: #9eabb33d;
    }
    
    .book_form{
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        padding :20px;
    }
    
    .deletePerson{
        cursor: pointer;
    }
    
    .deletePerson i{
        font-size: 19px;
        color: #ffffff;
        background-color: #f20000;
        padding: 5px;
        border-radius: 5px;
        box-shadow: 0 1px 4px rgba(21, 13, 19, 0.83);
    }
    
    .total_price{
        margin-top: 30px;
        margin-bottom: 20px;
    }
    
    #total_price{
        font-size:22px;
        font-weight:bold;
    }

    .book_details{
        background-color: #808b911f;
        border-radius: 4px;
        padding: 10px;
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        margin-bottom: 5px;
    }

    .form_gp{
        font-family: 'Noto Sans TC', sans-serif;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .submit_error{
        color: red;
        margin-top: 10px;
        display: none;
    }

    .credit_card_error{
        color: red;
        margin-top: 10px;
        display: none;
    }

    .submit_process{
        color: #2c9554;
        margin-top: 10px;
        display: none;
    }

    .credit_card_img{
        padding-top:20px;
    }

    .book_person{
        margin-bottom: 5px;
    }

    .lds-hourglass {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }
    .lds-hourglass:after {
        content: " ";
        display: block;
        border-radius: 50%;
        width: 0;
        height: 0;
        margin: 6px;
        box-sizing: border-box;
        border: 30px solid #37454d;
        border-color: rgba(55, 69, 77, 0.6) transparent #819da5 transparent;
        animation: lds-hourglass 1.2s infinite;
    }
    @keyframes lds-hourglass {
        0% {
            transform: rotate(0);
            animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
        }
        50% {
            transform: rotate(900deg);
            animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        }
        100% {
            transform: rotate(1800deg);
        }
    }

    .px_loading{
        text-align: center;
        position: absolute;
        left: 47%;
        top: 30%;
        z-index: 50;
        display: none;
    }

    .credit_card_info{
        margin-top: 10px;
    }

    .skip_flight{
        font-size: 22px;
        font-weight: bold;
    }

    .skip_btn{
        font-family: 'Noto Sans TC', sans-serif;
        border: 1px solid #ffffff;
        border-radius: 4px;
        padding: 5px;
        transition: 0.2s all;
        cursor: pointer;
        float: right;
    }

    .skip_btn:hover{
        background-color: #37454d;
        color: white;
        border: none;
    }

    .ppl_checkbox{
        display: inline-block;
        box-shadow: none;
        margin: 0px;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .ppl_label{
        vertical-align: top;
        font-size: 18px;
        margin-right: 10px;
    }

    .ppl_check_gp{
        margin-top:20px;
    }

    .pass_notice{
        margin-top: 20px;
        color: #626262;
        font-size: 11px;
    }

    .plane_section .flight_box_details .fas{
        color: #445691;
        margin-right: 5px;
        margin-left: 5px;
        font-size: 20px;
    }
    
    .final_label{
        font-size: 20px;
        color:#2d6098;
        font-weight: bold;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}"/>

<div class="flight_searchbar">
    {!! Form::open(array('route' => 'flight.search', 'id' => 'flight-search-form', 'data-parsley-validate' => '')) !!}
    <div class="row flight_searchbar_row">
        <div class="col-md-2">
            <label name="subject">國家 Country</label>
            <input id="country" name="country" class="form-control" type="text" maxlength="30" autocomplete="off">
            <ul class="list-unstyled"></ul>
        </div>
        <div class="col-md-1">
            <label name="subject">國家代碼 Code</label>
            <input id="countrycode" name="countrycode" class="form-control" type="text" maxlength="30" readonly>
        </div>
        <div class="col-md-2">
            <label name="subject">出發機場 Departure Airport</label>
            <select id="departure_airport" name="departure_airport" class="form-control">
                <option value="HKG">Hong Kong International Airport</option>
            </select>
        </div>
        <div class="col-md-2">
            <label name="subject">城市 City</label>
            <select id="city" name="city" class="form-control"></select>
        </div>
        <input type="hidden" id="trip" name="trip_id" value="{{Input::get('trip')}}">
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
        <div class="col-md-2">
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

<div class="plane_title">
    <div class="title_unselect">
        @if($departure != null)
            <i class="fas fa-plane-departure"></i> 選擇由 香港 HKG 飛往 {{Input::get('country')}} - {{$city}} ({{$departure_airport}}) 的航班
        @else
            <i class="fas fa-exclamation-circle"></i> 找不到任何由 香港 HKG 飛往 {{Input::get('country')}} ({{$departure_airport}}) 的航班
        @endif
    </div>
    <div class="title_selected">
        <div class="dep_title_selected">
            <span class="dep_t">
                <img src="https://countryflags.io/HK/flat/64.png">
                <i class="fas fa-plane-departure"></i>
                <span class="det_g">
                    <div class="selected_dep_flight"></div>
                    <span class="reselect_dep"><i class="fas fa-plane"></i></span>
                </span>
            </span>
        </div>

        <div class="plane_title_arrival">
            <div class="arrival_title">選擇由 {{Input::get('country')}} - {{$city}} ({{$departure_airport}}) 返回 香港 HKG 的航班
                <i class="fas fa-plane-arrival" style="transform: scaleX(-1);"></i>
            </div>

            <div class="arrival_title_selected">
                <span class="reselect_arr"><i class="fas fa-plane arr_bk_i"></i></span>
                <div class="selected_arr_flight reselect_arr_btn"></div>
                <i class="fas fa-plane-arrival arr_i"></i>
                <img src="https://countryflags.io/{{Input::get('code')}}/flat/64.png">
            </div>
        </div>
    </div>

</div>

<div class="flight_content_section">
    <div class="departure_section plane_section">


        <input type="hidden" name="selected_dep_flight" id="selected_dep_flight" value="">

        <div class="departure_flight">

            <div class="flight_box_skip" onclick="clickDeparture('','')">
                <input type="hidden" id="price_" value="0">
                <input type="hidden" id="taxes_" value="0">
                <div class="flight_box_header">
                    <div class="row">
                        <div class="col-md-9 skip_flight">
                            <i class="fas fa-times-circle"></i> 只預訂回程航班 Only book arrival flight.
                        </div>
                        <div class="col-md-3 select_btn_col">
                            <span class="skip_btn">點選以跳過 SKIP</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($departure != null)
                @foreach($departure as $k => $dep)
                    <div class="flight_box" id="flight_{{$dep['carrier'].$dep['number']}}">
                        <input type="hidden" id="source_{{$dep['carrier'].$dep['number']}}" value="{{$k}}">
                        <input type="hidden" id="price_{{$dep['carrier'].$dep['number']}}" value="{{$dep['price_basic']}}">
                        <input type="hidden" id="taxes_{{$dep['carrier'].$dep['number']}}" value="{{$dep['price_taxes']}}">
                        <div class="flight_box_header" data-toggle="collapse" data-target="#coll-{{$dep['carrier'].$dep['number']}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="http://pics.avs.io/250/40/{{$dep['carrier']}}.png">
                                </div>
                                <div class="col-md-2 flight_airline">
                                    {{FlightStats::AirlinesData($dep['carrier'])}}
                                </div>
                                <div class="col-md-1 flight_number">
                                    {{$dep['carrier'].$dep['number']}}
                                </div>
                                <div class="col-md-2 flight_time">
                                    <i class="far fa-clock"></i> {{$dep['departure_date'].' '.$dep['departure_time']}}
                                </div>
                                <div class="col-md-2 flight_price">
                                    $ {{$dep['price_basic']}} <span class="flight_class">{{$dep['class']}}</span>
                                </div>
                                <div class="col-md-2 select_btn_col">
                                    <span class="select_btn" onclick="clickDeparture('{{$dep['carrier']}}','{{$dep['number']}}')">選擇此航班</span>
                                    <i class="fas fa-angle-double-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flight_box_details collapse" id="coll-{{$dep['carrier'].$dep['number']}}">
                            <div class="gws-flights-results__dotted-flight-icon"></div>
                            <div class="flight_info">
                                <div class="flight_info_attr">
                                    出發 <i class="fas fa-plane-departure"></i>
                                    {{$dep['departure_date'].' '.$dep['departure_time'].' (GMT'.$dep['departure_timezone'].')'}}
                                    <i class="fas fa-city"></i>
                                    由 {{Input::get('from')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('from'));
                                        print_r('('.$from[0]['name'].') Terminal '.$dep['departure_terminal']);
                                    @endphp
                                </div>
                                <br><br>
                                <div class="flight_info_attr flight_info_mobile">
                                    到達 <i class="fas fa-plane-arrival"></i>
                                    {{$dep['arrival_date'].' '.$dep['arrival_time'].' (GMT'.$dep['arrival_timezone'].')'}}
                                    <i class="fas fa-city"></i>
                                    到 {{Input::get('to')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('to'));
                                        print_r('('.$from[0]['name'].') Terminal '.$dep['arrival_terminal']);
                                    @endphp
                                </div>
                            </div>
                            <div class="flight_info_equi">
                                <span class="fly_detail"><i class="fas fa-wind"></i> 飛行時間 - {{$dep['duration']}}</span>
                                <span class="fly_detail"><i class="fas fa-fighter-jet"></i> 飛機型號 - {{$dep['aircraft_gp'][$dep['aircraft']]}}</span>
                                <span class="fly_detail"><i class="fas fa-hand-holding-usd"></i> 燃油附加費 - $ {{$dep['price_taxes']}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no_result">
                    <div id="no_result_close">
                        {{--<i class="fas fa-times-circle"></i>--}}
                    </div>
                    <i class="fas fa-plane"></i>
                    找不到任何直航航班，請嘗試其他機場。<br>
                    <span>No flight result found. Please try another airport.</span>
                </div>
            @endif
        </div>
    </div>

    <div class="arrival_section plane_section">
        <input type="hidden" name="selected_arr_flight" id="selected_arr_flight" value="">

        <div class="departure_flight">

            <div class="flight_box_skip" onclick="clickArrival('','')" style="background-color: #5f96a3">
                <input type="hidden" id="price_" value="0">
                <input type="hidden" id="taxes_" value="0">
                <div class="flight_box_header">
                    <div class="row">
                        <div class="col-md-9 skip_flight">
                            <i class="fas fa-times-circle"></i> 只預訂出發航班 Only book departure flight.
                        </div>
                        <div class="col-md-3 select_btn_col">
                            <span class="skip_btn">點選以跳過 SKIP</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($arrival != null)
                @foreach($arrival as $k => $arr)
                    <div class="flight_box" id="flight_{{$arr['carrier'].$arr['number']}}">
                        <input type="hidden" id="source_{{$arr['carrier'].$arr['number']}}" value="{{$k}}">
                        <input type="hidden" id="price_{{$arr['carrier'].$arr['number']}}" value="{{$arr['price_basic']}}">
                        <input type="hidden" id="taxes_{{$arr['carrier'].$arr['number']}}" value="{{$arr['price_taxes']}}">
                        <div class="flight_box_header" data-toggle="collapse" data-target="#coll-{{$arr['carrier'].$arr['number']}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="http://pics.avs.io/250/40/{{$arr['carrier']}}.png">
                                </div>
                                <div class="col-md-2 flight_airline">
                                    {{FlightStats::AirlinesData($arr['carrier'])}}
                                </div>
                                <div class="col-md-1 flight_number">
                                    {{$arr['carrier'].$arr['number']}}
                                </div>
                                <div class="col-md-2 flight_time">
                                    <i class="far fa-clock"></i> {{$arr['departure_date'].' '.$arr['departure_time']}}
                                </div>
                                <div class="col-md-2 flight_price">
                                    $ {{$arr['price_basic']}} <span class="flight_class">{{$arr['class']}}</span>
                                </div>
                                <div class="col-md-2 select_btn_col">
                                    <span class="select_btn" onclick="clickArrival('{{$arr['carrier']}}','{{$arr['number']}}')">選擇此航班</span>
                                    <i class="fas fa-angle-double-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flight_box_details collapse" id="coll-{{$arr['carrier'].$arr['number']}}">
                            <div class="gws-flights-results__dotted-flight-icon"></div>
                            <div class="flight_info">
                                <div class="flight_info_attr">
                                    出發 <i class="fas fa-plane-departure"></i>
                                    {{$arr['departure_date'].' '.$arr['departure_time'].' (GMT'.$arr['departure_timezone'].')'}}
                                    <i class="fas fa-city"></i>
                                    由 {{Input::get('to')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('to'));
                                        print_r('('.$from[0]['name'].') Terminal '.$arr['departure_terminal']);
                                    @endphp
                                </div>
                                <br><br>
                                <div class="flight_info_attr flight_info_mobile">
                                    到達 <i class="fas fa-plane-arrival"></i>
                                    {{$arr['arrival_date'].' '.$arr['arrival_time'].' (GMT'.$arr['arrival_timezone'].')'}}
                                    <i class="fas fa-city"></i>
                                    到 {{Input::get('from')}}
                                    @php
                                        $from = FlightStats::AirportsData(null,Input::get('from'));
                                        print_r('('.$from[0]['name'].') Terminal '.$arr['arrival_terminal']);
                                    @endphp
                                </div>
                            </div>
                            <div class="flight_info_equi">
                                <span class="fly_detail"><i class="fas fa-wind"></i> 飛行時間 - {{$arr['duration']}}</span>
                                <span class="fly_detail"><i class="fas fa-fighter-jet"></i> 飛機型號 - {{$arr['aircraft_gp'][$arr['aircraft']]}}</span>
                                <span class="fly_detail"><i class="fas fa-hand-holding-usd"></i> 燃油附加費 - $ {{$arr['price_taxes']}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="booking_section plane_section">


        <!-- The flight booking form will display here -->
        <div class="book_form">
            {!! Form::open(array('route' => 'flight.book', 'data-parsley-validate' => '', 'id' => 'flight_form' )) !!}
            <div class="row">
                
                <div class="col-md-6 form_gp">
                    <label name="subject">國家 Country</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-globe-asia"></i></span>
                        <input value="{{$country}}" id="form_departure_date" name="final_country" class="form-control final_label" type="text" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">城市 City</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-city"></i></span>
                        <input value="{{$city}}" id="form_arrival_date" name="final_city" class="form-control final_label" type="text" readonly>
                    </div>
                </div>

                <div class="col-md-6 form_gp">
                    <label name="subject">出發日期 Departure Date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                        <input value="{{Input::get('start')}}" id="form_departure_date" name="form_departure_date" class="form-control" type="text" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">回程日期 Arrival Date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                        <input value="{{Input::get('end')}}" id="form_arrival_date" name="form_arrival_date" class="form-control" type="text" readonly>
                    </div>
                </div>


                <div class="col-md-6 form_gp">
                    <label name="subject">出發航班 Departure Flight</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-plane"></i></span>
                        <input id="form_departure" name="form_departure" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">回程航班 Arrival Flight</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-plane"></i></span>
                        <input id="form_arrival" name="form_arrival" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">航班費用 Departure Price</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="form_departure_price" name="form_departure_price" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">航班費用 Arrival Price</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="form_arrival_price" name="form_arrival_price" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">燃油附加費 Departure Taxes</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="form_departure_tax" name="form_departure_tax" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">燃油附加費 Arrival Taxes</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="form_arrival_tax" name="form_arrival_tax" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
                <div class="col-md-6 form_gp">
                    <label name="subject">每位乘客 Basic price per person</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="form_basic_price" name="form_basic_price" class="form-control" type="text" maxlength="30" readonly>
                        <input id="encrypted_code" name="encrypted_code" type="hidden">
                    </div>
                </div>
            </div>
        
            <br>
            <label name="subject">乘客 Passenger</label>
            
            <div class="book_details">
                <div class="row book_person" id="new_0">                 
                    <div class="col-md-3">
                        名稱 Name
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-user-alt"></i></span>
                            <input id="people_name" name="people_name[]" class="form-control" type="text" maxlength="30">
                        </div>
                    </div>
                    <div class="col-md-3">
                        護照號碼 Passport Number
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-passport"></i></span>
                            <input id="people_passport" name="people_passport[]" class="form-control" type="text" maxlength="30">
                        </div>
                    </div>
                    <div class="col-md-2 ppl_check_gp">
                        <input type="hidden" name="dep_people[0]" value="0" />
                        <input type="hidden" name="arr_people[0]" value="0" />
                        <input type="checkbox" name="dep_people[0]" value="1" class="form-control ppl_checkbox dep_ckbox" checked>
                        <span class="ppl_label">出發</span>
                        <input type="checkbox" name="arr_people[0]" value="1" class="form-control ppl_checkbox arr_ckbox" checked>
                        <span class="ppl_label">回程</span>
                    </div>
                </div>
            </div>
            
            <div class="button button-3d button-caution button-rounded add_new_person" onclick="addNewPerson()">
                <i class="fas fa-plus-circle"></i>
            </div>

            <div class="row pass_notice">
                <div class="col-md-12">
                    <span>*請輸入乘客名稱，護照號碼只能輸入數目字，出發/回程類請最少選擇一項。 <br>
                        Please enter passenger name, passport number in digital number and choose at least one flight type.
                    </span>
                </div>
            </div>
            
            <div class="row total_price">
                <div class="col-md-6">
                    <label name="subject">總費用 Total Price</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                        <input id="total_price" name="total_price" class="form-control" type="text" maxlength="30" readonly>
                    </div>
                </div>
            </div>
            
            
            <label for="method">付款方式 Payment Method</label>
            <select class="form-control" name="payment_method" id="payment_method">
                @foreach($payment_method as $pay)
                    <option value='{{ $pay->id }}'>{{ $pay->type }}</option>
                @endforeach
            </select>

            <div class="credit_card_form">
                <div class="row">
                    <div class="col-md-1 credit_card_img" style="text-align: center">
                        <img src="images/visa.png">
                    </div>
                    <div class="col-md-6">
                        <i class="far fa-credit-card"></i> 信用卡資料 Credit Card

                        <div class="credit_card_info well">
                            <label for="card_number">信用卡號碼 Card Number</label>
                            <input class="form-control" maxlength="16" name="card_number" type="text"
                                   id="card_number">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class='input-group'>
                                        <label for='expired_date'>到期日子 Expired Date</label>
                                        <input class="form-control" placeholder='' type='month' name="expired_date"
                                               id="expired_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="security_number">安全碼 Security Number</label>
                                    <input class="form-control" maxlength="3" name="security_number" type="text"
                                           id="security_number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row submit_error">
                <div class="col-md-12">
                    <span>*乘客資料輸入錯誤，請確保輸入所有乘客名稱及護照號碼 Please enter passenger data correctly.</span>
                </div>
            </div>
            <div class="row credit_card_error">
                <div class="col-md-12">
                    <span>*請填寫信用卡資料 Please enter your credit card information.</span>
                </div>
            </div>


            <div class="row submit_process">
                <div class="col-md-12">
                    <span><i class="fas fa-check-circle"></i> 已通過驗證！ Validation passed!</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-action btn-submit" style="margin-top: 20px">
                        <i class="fas fa-check-circle"></i> 確認 Confirm
                    </button>
                </div>
            </div>
            @php
                $departure = json_encode($departure,true);
                $arrival = json_encode($arrival, true);
            @endphp
            <input type="hidden" name="source_dep" id="source_dep" value="{{$departure}}">
            <input type="hidden" name="source_arr" id="source_arr" value="{{$arrival}}">

            <input type="hidden" name="source_dep_num" id="source_dep_num">
            <input type="hidden" name="source_arr_num" id="source_arr_num">
            <input type="hidden" name="trip" id="trip" value="{{Input::get('trip')}}">
            <input type="hidden" name="country_name" value="{{$country}}">
            <input type="hidden" name="country_code" value="{{$code}}">
            <input type="hidden" name="city_name" value="{{$city}}">
            {!! Form::close() !!}
        </div>

    </div>

    <div class="px_loading">
        <div class="lds-hourglass"></div>
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
    setTimeout(function () {
        var country_code =  {!! json_encode($code) !!};
        var city =  {!! json_encode($city) !!};

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        GetCities(country_code,CSRF_TOKEN);
        $("#city").val(city);
        getAirports(city);
    }, 1000);
                
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 350;  //time in ms
    
    function delay(callback, ms) {
        var timer = 0;
        return function() {
          var context = this, args = arguments;
          clearTimeout(timer);
          timer = setTimeout(function () {
            callback.apply(context, args);
          }, ms || 0);
        };
    }

    //on keyup, start the countdown
    $('#country').keyup(delay(function(e){

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
    }, 500));

    function GetCities(code,token){

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


    $("#country").focus(function () {
        $("#country").trigger("keyup");
    });

    $("#country").blur(function () {
        $(".list-unstyled").fadeOut();
    });
    
    $("#city").change(function(){
        getAirports($(this).val());
    });

    function getAirports(city){
        //alert(city);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        //Ajax call api
        $.ajax({
            url: 'getairportlist',
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

    //Disable search form submit by `Enter` key
    $('#flight-search-form').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });
</script>


<script>
    function clickDeparture(fs,fno) {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('.title_selected').show();
        $('.title_unselect').hide();
        $('#selected_dep_flight').val(fs+fno);
        $('.selected_dep_flight').html('出發 - '+fs+fno);
        $('.departure_section').fadeOut();
        $('.arrival_section').fadeIn();

        var dep_source = $('#source_'+fs+fno).val();
        if(fs == ''){
            $('.arrival_section .flight_box_skip').hide();
            $('#source_dep_num').val('');
            $('.dep_ckbox').hide();
            $('.arr_ckbox').css("pointer-events", "none");
            $('.arr_ckbox').prop( "checked", true );
        } else {
            $('.arrival_section .flight_box_skip').show();
            $('#source_dep_num').val(dep_source);
            $('.dep_ckbox').show();
            $('.arr_ckbox').css("pointer-events", "auto");
        }
    }

    function clickArrival(fs,fno) {
        //alert(fs); alert(fno);
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('#selected_arr_flight').val(fs+fno);
        $('.selected_arr_flight').html('回程 - '+fs+fno);
        $('.arrival_section').fadeOut();
        $('.arrival_title_selected').show();
        $('.plane_title_arrival .arrival_title').hide();
        $('.booking_section').fadeIn();
        
        var dep_flight = $('#selected_dep_flight').val();
        var arr_flight = fs+fno;
        var dep_price = $('#price_'+dep_flight).val();
        var arr_price = $('#price_'+arr_flight).val();
        var dep_tax = $('#taxes_'+dep_flight).val();
        var arr_tax = $('#taxes_'+arr_flight).val();

        var arr_source = $('#source_'+fs+fno).val();
        if(fs == ''){
            $('#source_arr_num').val('');
            $('.arr_ckbox').hide();
            $('.dep_ckbox').css("pointer-events", "none");
            $('.dep_ckbox').prop( "checked", true );
        } else {
            $('#source_arr_num').val(arr_source);
            $('.arr_ckbox').show();
            $('.dep_ckbox').css("pointer-events", "auto");
        }

        $('#form_departure').val(dep_flight);
        $('#form_arrival').val(arr_flight);

        $('#form_departure_price').val(dep_price);
        $('#form_arrival_price').val(arr_price);

        $('#form_departure_tax').val(dep_tax);
        $('#form_arrival_tax').val(arr_tax);
        
        var total = parseInt(dep_price)+parseInt(arr_price)+parseInt(dep_tax)+parseInt(arr_tax);
        $('#form_basic_price').val(total);
        $('#total_price').val(total);

        //Encryption process
        var enc = window.btoa(total);
        var dep = window.btoa(dep_flight);
        var arr = window.btoa(arr_flight);
        var token = '{{$token}}';
        var etoken = token+','+enc+','+dep+','+arr;
        $('#encrypted_code').val(etoken);

        $('#new_0 #people_name').focus();
    }

    $('.reselect_dep, .selected_dep_flight').click(function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('.arrival_title_selected').hide();
        $('.arrival_section').fadeOut();
        $('.booking_section').fadeOut();
        $('.departure_section').fadeIn();
        $('#selected_dep_flight').val('');
        $('.selected_dep_flight').html('');
    });

    $('.reselect_arr, .reselect_arr_btn').click(function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        //$('.dep_t').hide();
        $('.arrival_section').fadeIn();
        $('.departure_section').fadeOut();
        $('.booking_section').fadeOut();
        $('#selected_arr_flight').val('');
        $('.selected_arr_flight').html('');
    });

    $('.flight_box_header').hover(function () {
        //$(this).click();
    })
</script>
<script>
    $(".plane_title").sticky({
        topSpacing:0,
        zIndex : 100
    });

    $('.plane_title').on('sticky-start', function() {
        $('.plane_title').css("background-color", "#37454d");
        $('.plane_title').css("color", "#ffffff");
    });
    $('.plane_title').on('sticky-end', function() {
        $('.plane_title').css("background-color", "#ededed");
        $('.plane_title').css("color", "#000000");
    });

</script>

<script>
    var ppl = 1;
    function addNewPerson(){
        $('.book_details').append('' +
            '<div class="row book_person" id="new_'+ppl+'">' +
                '<div class="col-md-3">' +
                    '名稱 Name' +
                    '<div class="input-group">' +
                        '<span class="input-group-addon"><i class="fas fa-user-alt"></i></span>' +
                        '<input id="people_name" name="people_name[]" class="form-control" type="text" maxlength="30">' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                    '護照號碼 Passport Number' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><i class="fas fa-passport"></i></span>' +
                        '<input id="people_passport" name="people_passport[]" class="form-control" type="text" maxlength="30">' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-2 ppl_check_gp">' +
                    '<input type="hidden" name="dep_people['+ppl+']" value="0" />' +
                    '<input type="hidden" name="arr_people['+ppl+']" value="0" />' +
                    '<input type="checkbox" name="dep_people['+ppl+']" value="1" class="form-control ppl_checkbox dep_ckbox" checked>' +
                        '<span class="ppl_label"> 出發</span>' +
                    '<input type="checkbox" name="arr_people['+ppl+']" value="1" class="form-control ppl_checkbox arr_ckbox" checked>' +
                        '<span class="ppl_label"> 回程</span>' +
                '</div>' +
            '<div class="col-md-1 deletePerson" onclick="deletePerson('+ppl+')">' +
            '<br>' +
            '<i class="fas fa-user-times"></i></div></div>' +
        '');

        ppl++;
        var basic = $('#form_basic_price').val();
        var numPpl = $('.book_person').length;
        var total_price = basic * numPpl;   //Use number of .book_person div to count total number of people
        $('#total_price').val(total_price);
    }
    
    function deletePerson(num){
        $('#new_' + num).remove();
        //ppl--;  //no need to minus people to avoid delete-div-bug, can keep adding people and skip div like 1,3,4,5
        var new_price = parseInt($('#total_price').val()) - parseInt($('#form_basic_price').val());
        $('#total_price').val(new_price);
    }
    
    $("#payment_method").change(function () {

    var type = $(this).val();

        switch (type) {
            case '1':
                $('.credit_card_img').html('<img src="images/visa.png">');
                break;
            case '2':
                $('.credit_card_img').html('<img src="images/mc.png">');
                break;
            case '3':
                $('.credit_card_img').html('<img src="images/amex.png">');
                break;
            case '4':
                $('.credit_card_img').html('<img src="images/discover.png">');
                break;
        }
    });

    function FormValidation(){

        var pass = true;

        $(".book_person").each(function(){
            var bk_name = $(this).find('#people_name').val();
            if(bk_name != null){
                var bk_passport = $(this).find('#people_passport').val();
                if(!(Math.floor(bk_passport) == bk_passport && $.isNumeric(bk_passport))){
                    pass = false;
                    return false;
                } else {
                    var ck_dep = $(this).find(".dep_ckbox").prop("checked");
                    var ck_arr = $(this).find(".arr_ckbox").prop("checked");
                    if(ck_dep == false && ck_arr == false) {
                        pass = false;
                        return false;
                    }
                }
            } else {
                pass = false;
                return false;
            }
        });

        if(pass == true){
            //Booking people data validation pass, now validate payment method
            console.log('pass bookng');
            var card_number = $('#card_number').val();
            var expired_date = $('#expired_date').val();
            var security_number = $('#security_number').val();
            
            if(card_number == '' || expired_date == '' || security_number == ''){
                pass = false;
                $('.credit_card_error').fadeIn();
                setTimeout(function () {
                    $('.credit_card_error').fadeOut();
                }, 2000);
                console.log('null');
            } else {
                console.log('process payment');
                //Call ajax handle credit card validation process
            }
        } else {
            pass = false;
            $('.submit_error').fadeIn();
            setTimeout(function () {
                $('.submit_error').fadeOut();
            }, 2000);
        }

        return pass;
    }

    $(".btn-submit").click(function(e){

        if(FormValidation() == false) {
            e.preventDefault();
        } else {
            //If basic check in frontend okay, delay form submit 1.5s to display successful message.
            e.preventDefault();
            $('.submit_process').fadeIn();
            setTimeout( function () {
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $('.px_loading').show();
                $(".booking_section , #sticky-wrapper , .flight_searchbar , .navbar").css("opacity", "0.2");
                $(".booking_section , #sticky-wrapper , .flight_searchbar , .navbar").css("pointer-events", "none");
                $('#flight_form').submit();
            }, 1000);
        }

    });
    
    $(".btn-search").click(function(e){

        var trip = '{{Input::get('trip')}}';

        if(trip.length != 0){
            //e.preventDefault(); //temporary disabled
        }

        $("html, body").animate({scrollTop: 0}, "slow");
        $('.px_loading').show();
        $(".plane_section , #sticky-wrapper , .flight_searchbar , .navbar").css("opacity", "0.2");
        $(".plane_section , #sticky-wrapper , .flight_searchbar , .navbar").css("pointer-events", "none");

    });
</script>



@endsection