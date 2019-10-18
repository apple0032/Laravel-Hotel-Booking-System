@extends('index')

@section('title', ' - Planning')

@section('content')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.js"></script>
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

        .input_city , .input_weighting{
            margin-top: 60px;
            margin-left: 28%;
            margin-right: 28%;
        }

        .input_timer{
            background-color: #f7f7f7;
            color: #000000;
            border-radius: 5px;
            padding: 10px 50px 30px 50px;
            font-size: 20px;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        }

        .input_weighting{
            color: #183849;
            background-color: #f7f7f7;
            border-radius: 5px;
            padding: 40px 50px 20px 50px;
            font-size: 20px;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        }

        .input_map{
            margin-top: 30px;
            margin-left: 15%;
            margin-right: 15%;
            color: #565656;
            background-color: #f7f7f7;
            border-radius: 5px;
            padding: 0px 10px 10px 10px;
            font-size: 20px;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        }
        
        .input_weighting i{
            margin-right: 8px;
            width: 28px;
        }
        
        .noUi-handle{
            border: 1px solid #a4a4a4;
            background: #a0a0a0;
            border-radius: 8px;
        }

        .weighting_group{
            margin-bottom: 15px;
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

        .step-1{
            /*display: none;*/
        }

        .step-4{
            display: none;
            /*margin-bottom: 200px;*/
            margin-top: 50px;
        }

        .step-2, .step-3{
            display: none;
            margin-top: 50px;
        }

        .planning2{
            color: white;
            margin-left: 40%;
            margin-right: 40%;
            margin-top: 60px;
        }

        @media only screen and (max-width: 800px) {
            .planning2{
                margin-left: 20%;
                margin-right: 20%;
            }
        }

        .gj-textbox-md{
            border-bottom: 2px solid rgba(0, 0, 0, 0.42) !important;
            color: rgba(0, 0, 0, 0.87) !important;
            font-size: 22px !important;
        }

        .gj-icon{
            color: #000 !important;
        }

        .gj-timepicker{
            width: 100% !important;
        }

        .step-2_label, .step-3_label, .step-4_label{
            font-size: 30px;
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .timer_label{
            font-size: 21px;
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

        #map{
            height: 450px;
            border: 1px solid #aaaaaa;
            border-radius: 5px;
        }

        .map_text{
            font-size: 16px;
            color: black;
            margin-bottom: 5px;
            float: right;
        }

        .map_searching{
            padding: 10px 20px;
        }

        #search_str{
            margin-top: 10px;
        }

        .search_result{
            font-size:10px;
            margin-bottom: 10px;
        }

        .search_option{
            border: 1px solid #606060;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 1px;
            width: 100%;
            cursor: pointer;
            transition: 0.2s;
        }

        .search_option:hover{
            background-color: black;
            color: white;
        }

        .generate_btn{
            text-align: center;
            color: white;
            font-size: 20px;
            padding-right: 40%;
            padding-left: 40%;
            margin-top: 25px;
        }

        .gen-btn{
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 5px;
            background-color: #4ab879;
            cursor: pointer;
        }

        .hottest_select{
            margin-top: 25px;
        }

        .hottest_title{
            border-bottom: 1px solid #173848;
            font-weight: bold;
        }

        /* Custom radio buttons */
        input[type="radio"] + label {
          display: inline-block;
          cursor: pointer;
          position: relative;
          padding-left: 30px;
          margin-right: 15px;
          font-size: 15px;
        }
        input[type="radio"] + label:before {
          content: "";
          display: block;
          width: 22px;
          height: 22px;
          margin-right: 14px;
          position: absolute;
          top: -3px;
          left: 0;
          border: 1px solid #aaa;
          background-color: #fff;
          border-radius: 50%;
        }
        input[type="radio"] {
          display: none !important;
          *display: inline;
        }
        input[type="radio"]:checked + label:after {
          content: "";
          display: block;
          position: absolute;
          top: 2px;
          left: 5px;
          width: 12px;
          height: 12px;
          border-radius: 50%;
          background: #173848;
        }
        /* Custom checkbox */
        input[type="checkbox"] + label {
          display: inline-block;
          cursor: pointer;
          position: relative;
          padding-left: 30px;
          margin-right: 15px;
          font-size: 13px;
        }
        input[type="checkbox"] + label:before {
          content: "";
          display: block;
          width: 22px;
          height: 22px;
          margin-right: 14px;
          position: absolute;
          top: -3px;
          left: 0;
          border: 1px solid #aaa;
          background-color: #fff;
          border-radius: 5px;
        }
        input[type="checkbox"] {
          display: none !important;
          *display: inline;
        }
        input[type="checkbox"]:checked + label:after {
          content: "✔";
          font-size: 20px;
          line-height: 20px;
          color: #b7b7b7;
          display: block;
          position: absolute;
          top: 0;
          left: 4px;
          width: 20px;
          height: 20px;
          border-radius: 3px;
        }

        .openmap_btn{
            display: none;
        }

        .skipmap_btn, .openmap_btn{
            cursor: pointer;
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
            <div class="input_timer">
                <div class="timer_label">Start Time</div>
                <div>
                    <input id="starttime" name="starttime" readonly/>
                </div>

                <div class="timer_label">End Time</div>
                <div>
                    <input id="endtime" name="endtime" readonly/>
                </div>
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
    
    <div class="step-3 animated">
        <div class="step-3_label">What would you like to do in your trip?</div>
        <div class="input_weighting">
            @foreach($categories as $cat => $fa)
                <div class="row weighting_group">
                    <div class="col-md-3">
                        <i class="fas {{$fa}}"></i>
                        {{ucfirst($cat)}}
                    </div>
                    <div class="col-md-9">
                        <div id="slider_{{$cat}}"></div>
                    </div>
                    <input name="w_{{$cat}}" id="w_{{$cat}}" type="hidden" value="">
                </div>
            @endforeach
            <div class="hottest_select">
                <div class="hottest_title">Search Hottest/Random Attractions?</div>
              <div class="radio">
                <input id="first" type="radio" name="hot" value="1" checked>
                <label for="first">Hottest</label>
                <input id="second" type="radio" name="hot" value="0">
                <label for="second">Random</label>
              </div>
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


    <div class="step-4 animated">
        <div class="step-4_label">Do you have accommodation in your trip?</div>
        <div class="input_map">
            <span class="map_text"><i class="fas fa-map-marker-alt"></i> &nbsp;Drag the marker below.</span>
            <div class="row">
                <div class="col-md-2 map_searching">
                    <i class="fas fa-search"></i> &nbsp;Search
                    <input id="search_str" class="form-control" type="text" maxlength="30" autocomplete="off" placeholder="*Hotel name/Home">
                    <div class="search_result"></div>
                    <button id="search_place" type="button" class="btn btn-primary">Search</button>
                    <button id="search_clear" type="button" class="btn btn-default">Clear</button>
                </div>
                <div class="col-md-10">
                    <div id="map"></div>
                    <input type="hidden" id="accom_lat" name="accom_lat" value="22.444630">
                    <input type="hidden" id="accom_lng" name="accom_lng" value="114.170655">
                </div>
            </div>
        </div>

        <div class="generate_btn">
            <div class="gen-btn">
                Start Generating Itinerary
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
                        <label class="skipmap_btn"><i class="fas fa-minus-circle"></i> Skip </label>
                        <label class="openmap_btn"><i class="fas fa-home"></i> Map </label>
                    </span>
                </span>
            </span>
        </div>
        <input type="hidden" id="has_accom" name="has_accom" value="1">
    </div>

@endsection




@section('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7BhQ5f9OupkTJRgLg_vCehCi8AlLOSuQ"></script>
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

        $("#searchcity").focus();
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

            if (e.keyCode === 13) {
                $(".list-unstyled").fadeOut();
                if($(this).val() !== '') {
                    var validcity = searchCity($(this).val());
                    if (validcity === true) {
                        $('.start-btn').click();
                    } else {
                        displayInvalidMessage();
                    }
                } else {
                    alert("Please input city.");
                }
            }
        }, 200));


        $('.start-btn').click(function () {
            var cityname = $('#searchcity').val();
            var validcity = searchCity(cityname);

            if (validcity === true) {
                $('.step-1').addClass("bounceOutLeft");
                setTimeout(function() {
                    $('.step-1').hide();
                    $('.step-2').addClass("bounceInRight").show();
                    setTimeout(function(){
                        $('.step-2 .screen-actions').fadeIn();
                    }, 1000);
                }, 200);

            } else {
                displayInvalidMessage();
            }
        });

        function searchCity(cityname) {
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

            return validcity;
        }

        function displayInvalidMessage() {
            $('.invalid_message').fadeIn();
            $('.invalid_message').html("<i class=\"fas fa-exclamation-circle\"></i> Invalid City Name");
            setTimeout(function () {
                $('.invalid_message').fadeOut();
            }, 1500);
        }

        $('#starttime').timepicker({
            value: '10:00'
        });

        $('#endtime').timepicker({
            value: '20:00'
        });

        $(".step-2 #js_city_step_prev").click(function () {
            $('.step-2').removeClass("bounceInRight").hide();
            $('.step-2 .screen-actions').hide();
            setTimeout(function() {
                $('.step-1').removeClass("bounceOutLeft");
                $('.step-1').addClass("bounceInLeft").show();
            }, 200);
        });


        $(".step-2 #js_city_step_next").click(function () {

            $('.step-2').removeClass("bounceInRight").hide();
            $('.step-2 .screen-actions').hide();
            setTimeout(function() {
                $('.step-3').removeClass("bounceOutLeft");
                $('.step-3').addClass("bounceInRight").show();
            }, 200);
            
            setTimeout(function(){
                $('.step-3 .screen-actions').fadeIn();
            }, 1300);

        });
        
        
        $(".step-3 #js_city_step_prev").click(function () {
            $('.step-3').removeClass("bounceInRight").hide();
            $('.step-3 .screen-actions').hide();
            setTimeout(function() {
                $('.step-2').removeClass("bounceOutLeft");
                $('.step-2').addClass("bounceInLeft").show();
            }, 200);
            
            setTimeout(function(){
                $('.step-2 .screen-actions').fadeIn();
            }, 1300);
        });


        //var categories = ['shopping','eating','relaxing','sightseeing','playing','outdoor','discovering'];
        var categories = JSON.parse('<?php print_r(json_encode($categories)) ?>');
        console.log(categories);

        $.each(categories, function (key, value) {
            var slider = document.getElementById('slider_' + key);

            noUiSlider.create(slider, {
                start: [30],
                step: 1,
                range: {
                    'min': [10],
                    'max': [50]
                }
            });

            slider.noUiSlider.on('update.one', function (values) {
                $("#w_" + key).val(Math.floor(values[0]));
            });
        });


        $(".step-3 #js_city_step_next").click(function () {

            $('.step-3').removeClass("bounceInRight").hide();
            $('.step-3 .screen-actions').hide();
            setTimeout(function() {
                $('.step-4').removeClass("bounceOutLeft");
                $('.step-4').addClass("bounceInRight").show();
                //$("#search_str").focus();
            }, 200);

            setTimeout(function(){
                $('.step-4 .screen-actions').fadeIn();
            }, 1300);

        });

        $(".step-4 #js_city_step_prev").click(function () {
            $('.step-4').removeClass("bounceInRight").hide();
            $('.step-4 .screen-actions').hide();
            setTimeout(function() {
                $('.step-3').removeClass("bounceOutLeft");
                $('.step-3').addClass("bounceInLeft").show();
            }, 200);

            setTimeout(function(){
                $('.step-3 .screen-actions').fadeIn();
            }, 1300);
        });


        var map;
        var marker;
        initGoogleMap("22.444630","114.170655");

        function initGoogleMap(lat,lng) {
            var myLatLng = {lat: parseFloat(lat), lng: parseFloat(lng)};

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: myLatLng
            });

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable: true,
                icon: '../images/marker.png'
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                var lat = this.getPosition().lat();
                var lng = this.getPosition().lng();
                console.log(lat+','+lng);

                $('#accom_lat').val(lat);
                $('#accom_lng').val(lng);
            });
        }


        $("#search_place").click(function () {
            if($("#search_str").val() != '') {
                searchPlacesByGoogleApi($("#search_str").val());
            } else {
                alert("Please input string.");
            }
        });

        $("#search_str").on('keyup', function (e) {
            if (e.keyCode === 13) {
                if($(this).val() != '') {
                    searchPlacesByGoogleApi($(this).val());
                } else {
                    alert("Please input string.");
                }
            }
        });

        $("#search_clear").click(function () {
            $("#search_str").val("");
        });

        function searchPlacesByGoogleApi(keyword) {
            $.ajax({
                url: 'searchPlaces',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    keyword: keyword
                },
                dataType: 'JSON',
                success: function (data) {
                    $('.search_result').html('');
                    if(data['result'].length > 0){
                        var chtml = '';
                        $.each(data['result'], function (key, value) {
                            var lat = value['location']['lat'];
                            var lng = value['location']['lng'];
                            chtml += '<div class="search_option" onclick="changeMap('+lat+','+lng+')"><i class="fas fa-map-marker-alt">&nbsp; '+value['name']+'</i></div>';
                        });

                        $('.search_result').append(chtml);
                    }
                }
            });
        }

        function changeMap(lat,lng){
            initGoogleMap(lat,lng);
            $('#accom_lat').val(lat);
            $('#accom_lng').val(lng);
        }

        $('.skipmap_btn').click(function () {
            $(".input_map").css("opacity", "0.2").css("pointer-events", "none");
            $(".skipmap_btn").hide();
            $(".openmap_btn").fadeIn();
            $("#has_accom").val(0);
        });

        $('.openmap_btn').click(function () {
            $(".input_map").css("opacity", "1").css("pointer-events", "auto");
            $(".openmap_btn").hide();
            $(".skipmap_btn").fadeIn();
            $("#has_accom").val(1);
        });


        $(".gen-btn").click(function () {
            var city = $('#searchcity').val();
            var date = $('#daterange').val();
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();
            var priority = {};
            $.each(categories, function (key, value) {
                priority[key] = $('#w_'+key).val();
            });
            var point = ($("#accom_lat").val())+','+($("#accom_lng").val());
            var hottest = $('[name="hot"]:checked').val();
            var has_accom = $('#has_accom').val();

            $.ajax({
                url: 'generateItinerary',
                async: false,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    city: city,
                    date: date,
                    starttime: starttime,
                    endtime: endtime,
                    priority: priority,
                    hottest: hottest,
                    has_accom: has_accom,
                    point:point
                },
                dataType: 'JSON',
                success: function (data) {
                    if(data['status'] === 'success') {
                        location.href = "../trip/itinerary/"+data['id'];
                    }
                }
            });
        })


    </script>

@endsection