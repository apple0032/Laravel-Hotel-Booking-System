@extends('index')

@section('title', '| Flight')

@php
    use Illuminate\Support\Facades\Input;
    use App\FlightStats;
@endphp

@section('content')
<style>
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
</style>

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
            <i class="fas fa-plane-departure"></i> 選擇由香港 HKG 飛往 {{Input::get('country')}} 的航班
        </div>

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
    function clickDeparture(fs,fno) {
        alert(fs);
        alert(fno);
    }
</script>

@endsection