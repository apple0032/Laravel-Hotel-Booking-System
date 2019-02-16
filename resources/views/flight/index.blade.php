@extends('index')

@section('title', '| Flight')

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
        padding: 5px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
        border-radius: 2px;
        color: #0b1a27;
    }

    .list-unstyled li:hover {
        background-color: #dddddd;
        font-weight: bold;
    }

    .navbar {
        margin-bottom: 0px !important;
    }

    .search_box {
        margin-bottom: 40px;
        margin-left: 20%;
        margin-right: 20%;
        padding-top: 20px;
        padding-bottom: 30px;
    }

    .search_container {
        background-image: url("images/flight-banner.png");
        background-attachment: fixed;
        background-size: cover; /* <------ */
        background-repeat: no-repeat;
        background-position: top center;
        transition: background-color 3s linear !important;
        height: 800px;
    }

    .search_index {
        background-color: rgba(0, 0, 0, 0.75);
        color: #c7c7c7;
        -webkit-box-shadow: 0 0 0.8823em 0 rgba(0, 0, 0, 0.5);
        box-shadow: 0 0 0.8823em 0 rgba(0, 0, 0, 0.5);
        padding: 20px 10px 20px 10px;
    }

    .search_index .select2, .small_search_index .select2 {
        color: #000000;
    }

    @media (max-width: 768px) {
        .search_box {
            margin-left: 10%;
            margin-right: 10%;
        }
    }

    @media (max-width: 1600px) {
        .search_box {
            margin-left: 10%;
            margin-right: 10%;
        }
    }

    .btn-action {
        background: #4398e9;
        width: 100%;
        color: #fff;
        box-shadow: 0 0 1.8823em 0 rgba(132, 203, 255, 0.3);
    }

    .btn-action {
        font-family: 'Kanit', sans-serif;
        font-size: 21px !important;
    }

    .btn-action:hover {
        color: #caf8ee !important;
        transition: all .2s;
    }

    .search_tab{
        margin-left: -15px;
        margin-right: -15px;
    }

    .tab_type{
        display: inline-block;
        width:100px;
        text-align: center;
        padding: 7px;
        cursor: pointer;
    }

    .tab_type i{
        font-size: 20px;
        color: white;
    }

    .tab_active{
        background-color: #2d6098;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .tab_inactive{
        background-color: rgba(107, 107, 107, 0.5);
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        transition: 0.2s all;
    }

    .tab_inactive:hover{
        background-color: #1c8d98;
    }

    .footer_section{
         margin-bottom: 0px !important;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}"/>

        <div class="search_container">
            <div class="search_box">
                <div class="search_tab">
                    <div class="hotel_tab tab_type tab_inactive">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <div class="flight_tab tab_type tab_active">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                </div>
                <div class="row search_index">
                    <div class="col-md-12">
                        {!! Form::open(array('route' => 'flight.search', 'data-parsley-validate' => '')) !!}

                        <div class="row">
                            <div class="col-md-4">
                                <label name="subject">Country:</label>
                                <input id="country" name="country" class="form-control" type="text" maxlength="30">
                                <ul class="list-unstyled"></ul>
                            </div>
                            <div class="col-md-4">
                                <label name="subject">Country Code:</label>
                                <input id="countrycode" name="countrycode" class="form-control" type="text" maxlength="30" readonly>
                            </div>
                            <div class="col-md-4">
                                <label name="subject">Departure Airport:</label>
                                <select id="departure_airport" name="departure_airport" class="form-control">
                                    <option value="HKG">Hong Kong International Airport</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label name="subject">Arrival Airport:</label>
                                <select id="airport" name="airport" class="form-control"></select>
                            </div>
                            <div class="col-md-6">
                                <label name="subject">Departure & Arrival Date:</label>
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker">
                                        <input class="form-control" type="text" name="daterange" id="daterange" value="" readonly/>
                                        <span class="input-group-addon">
                                 <span class="glyphicon-calendar glyphicon"></span>
                               </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-action btn-search" style="margin-top: 20px">
                            <i class="fab fa-searchengin"></i> SEARCH
                        </button>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 600;  //time in ms

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
//              ranges: {
//                  'Today': [moment(), moment()],
//                  'This Month': [moment().startOf('month'), moment().endOf('month')],
//                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//              }
          }, function(start, end, label) {
            console.log("A date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

          });
        });


    $('.hotel_tab').click(function () {
        window.location.href = '../';
    })
</script>
@endsection