@extends('index')

@section('title', ' - Planning')

@section('content')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <style type="text/css" class="cp-pen-styles">

        body {
            background-image: none !important;
            background: #134a66;
            font-family: 'Quicksand', sans-serif !important;
        }

        .footer_section {
            margin-bottom: -40px !important;
        }

        .list-unstyled {
            position: absolute;
            z-index: 10;
            background-color: white;
            display: none;
            margin-top: -7px;
            border: 1px solid #b4b4b4;
            padding: 7px;
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

        .plan_box {
            color: white;
            margin-top: 50px;
            margin-right: 0;
            margin-left: 0;
        }

        .plan_box_title, .plan_box_title2 {
            text-align: center;
        }

        .plan_box_title {
            font-size: 40px;
        }

        .plan_box_title2 {
            font-size: 15px;
        }

        .input_city {
            margin-top: 60px;
            margin-left: 28%;
            margin-right: 28%;
        }

        @media only screen and (max-width: 800px) {
            .input_city {
                margin-left: 5% !important;
                margin-right: 5% !important;
            }
        }

        .input_city .input-group-addon {
            padding-right: 20px;
            padding-left: 20px;
        }

        .input_city .input-group-addon i {
            font-size: 20px;
        }

        #searchcity {
            height: 50px;
            font-size: 25px;
            padding-left: 15px;
        }

        .date_picker {
            margin-top: 20px;
        }

        #daterange, #datetimepicker {
            height: 50px;
        }

        #daterange {
            font-size: 20px;
            background-color: white;
        }

        .glyphicon {
            font-size: 20px;
        }

        .input_city_hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border-top: 2px solid rgba(191, 191, 191, 0.37);
        }

        .starting {
            text-align: center;
            color: white;
            font-size: 20px;
            padding-right: 20%;
            padding-left: 20%;
        }

        .start-btn {
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 5px;
            background-color: #4ab879;
            cursor: pointer;
        }

        .invalid_message {
            color: #c1c1c1;
            font-size: 18px;
        }

        .step-2{
            display: none;
            margin-top: 50px;
        }

        .planning2{
            color: white;
            margin-left: 40%;
            margin-right: 40%;
        }

        @media only screen and (max-width: 800px) {
            .planning2{
                margin-left: 20%;
                margin-right: 20%;
            }
        }

        .gj-textbox-md{
            border-bottom: 2px solid rgba(255, 255, 255, 0.42) !important;
            color: rgba(255, 255, 255, 0.87) !important;
            font-size: 22px !important;
        }

        .gj-icon{
            color: white !important;
        }

        .gj-timepicker{
            width: 100% !important;
        }

        .step-2_label{
            font-size: 30px;
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .timer_label{
            font-size: 20px;
            margin-top: 20px;
        }

        .screen-actions{
            display: none;
        }

        .prev-button {
            left: 0;
        }

        .next-button {
            right: 0;
        }

        .prev-button, .next-button {
            position: fixed;
            top: 45%;
            height: 60px;
            width: 140px;
            z-index: 2;
        }

        #js_city_step_prev .button{
            color: white;
            background-color: #64a0db;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        #js_city_step_next .button{
            color: white;
            background-color: #db7569;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>


    <div class="step-1 animated">
        <div class="row plan_box">
            <div class="col-md-12 plan_box_title">
                Create Your Own Customized Trip Itinerary
            </div>
            <div class="col-md-12 plan_box_title2">
                Create your travel itinerary according to specific conditions
            </div>
        </div>

        <div class="row input_city">
            <div class="col-md-12">
                <div class="search_city">
                    <div class="input-group">
                        <input id="searchcity" name="searchcity" class="form-control" type="text" maxlength="30"
                               autocomplete="off" placeholder="Which city do you want to go?">
                        <span class="input-group-addon"><i class="fas fa-globe-americas"></i></span>
                    </div>
                    <ul class="list-unstyled"></ul>
                    <input type="hidden" id="selected_city" name="selected_city" value="">
                    <span class="invalid_message"></span>
                </div>
            </div>

            <div class="col-md-12 date_picker">
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker">
                        <input class="form-control" type="text" name="daterange" id="daterange" value="" readonly/>
                        <span class="input-group-addon">
                            <span class="glyphicon-calendar glyphicon"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 input_city_hr"></div>

            <div class="col-md-12 starting">
                <div class="start-btn">
                    Start Planning
                </div>
            </div>
        </div>
    </div>

    <div class="step-2 animated">
        <div class="step-2_label">What is the start time and end time for your trip?</div>
        <div class="planning2">
            <div class="timer_label">Start Time</div>
            <div>
                <input id="starttime" name="starttime" />
            </div>

            <div class="timer_label">End Time</div>
            <div>
                <input id="endtime" name="endtime" />
            </div>
        </div>

        <div class="screen-actions">
            <span id="js_city_step_prev" class="prev-button js_city_step_move prev-btn-dsk">
                <span class="p-size button prev-btn-dsk">
                    <i class="icon-arrow-left prev-btn-dsk"></i>
                    Back
                </span>
            </span>
            <span id="js_city_step_next" class="next-button js_city_step_move next-btn-dsk">
                <span class="p-color p-size button next-btn-dsk">
                    <span id="js_city_next_step_title" class="step_title next-btn-dsk">
                        Next <i class="icon-arrow-right next-btn-dsk"></i>
                    </span>
                </span>
            </span>
        </div>
    </div>

@endsection




@section('scripts')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script>

        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                locale: {
                    format: 'YYYY-MM-DD'
                },
                minDate: new Date(),
                //startDate: '01/13/2019',
                showDropdowns: true,
                autoApply: true
            }, function (start, end, label) {
                console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            });
        });

        $('#searchcity').on("focus", function () {
            $(this).attr("placeholder", "Enter a city name");
        });

        $("#searchcity").focus(function () {
            $("#searchcity").trigger("keyup");
        });

        $("#searchcity").blur(function () {
            $(".list-unstyled").fadeOut();
        });


        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 150;  //time in ms
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        $('#searchcity').keyup(delay(function (e) {
            var keyword = $(this).val();

            if (keyword) {
                typingTimer = setTimeout(function () {

                    $.ajax({
                        url: 'searchCity',
                        async: false,
                        type: 'POST',
                        data: {
                            _token: CSRF_TOKEN,
                            name: keyword,
                            type: "match"
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                            $(".list-unstyled").html('');
                            console.log('ajax start');
                        },
                        success: function (data) {
                            //console.log(data);
                            if (data['status'] === 'success' && data['city'].length !== 0) {
                                $.each(data['city'], function (key, value) {
                                    if (key > 7) {
                                        return false;
                                    }
                                    $('.list-unstyled').append('' +
                                        '<li class="search_opt">' +
                                        '<div class="row">' +
                                        '<div class="col-md-12">' +
                                        value['name'] +
                                        '</div>' +
                                        '</div><input type="hidden" class="list-code" id="c-' + value['name'] + '" name="cityname" value="' + value['name'] + '"></li>');
                                });

                                $(".list-unstyled").fadeIn();
                            } else {
                                $(".list-unstyled").fadeOut();
                                console.log("no result");
                            }

                            $(".search_opt").each(function (index) {
                                $(this).on("click", function () {
                                    var name = $(this).text();
                                    $("#searchcity").val(name);
                                    $("#selected_city").val(name);

                                    var code = $(this).find('.list-code').val();
                                    console.log(code);
                                });
                            });
                        }
                    });

                }, doneTypingInterval);
            }
        }, 200));


        $('.start-btn').click(function () {
            var cityname = $('#searchcity').val();
            var validcity = true;

            $.ajax({
                url: 'searchCity',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    name: cityname,
                    type: "equal"
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data['city'].length === 0) {
                        validcity = false;
                    }
                }
            });

            if (validcity === true) {
                $('.step-1').addClass("bounceOutLeft");
                setTimeout(function() {
                    $('.step-1').hide();
                    $('.step-2').addClass("bounceInRight").show();
                    setTimeout(function(){
                        $('.screen-actions').fadeIn();
                    }, 1000);
                }, 200);

            } else {
                $('.invalid_message').fadeIn();
                $('.invalid_message').html("<i class=\"fas fa-exclamation-circle\"></i> Invalid City Name");
                setTimeout(function () {
                    $('.invalid_message').fadeOut();
                }, 1500);
            }
        });

        $('#starttime').timepicker({
            value: '10:00'
        });

        $('#endtime').timepicker({
            value: '20:00'
        });

        $("#js_city_step_prev").click(function () {
            $('.step-2').removeClass("bounceInRight").hide();
            $('.screen-actions').hide();
            setTimeout(function() {
                $('.step-1').removeClass("bounceOutLeft");
                $('.step-1').addClass("bounceInRight").show();
            }, 200);
        });


        $("#js_city_step_next").click(function () {

            var city = $('#searchcity').val();
            var date = $('#daterange').val();
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();

            $.ajax({
                url: 'generateItinerary',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    city: city,
                    date: date,
                    starttime: starttime,
                    endtime: endtime
                },
                dataType: 'JSON',
                success: function (data) {
                    if(data['status'] === 'success') {
                        location.href = "../trip/itinerary/"+data['id'];
                    }
                }
            });
        });


    </script>
@endsection