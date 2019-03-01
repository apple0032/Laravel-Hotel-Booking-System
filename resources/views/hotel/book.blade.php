@extends('main')

@section('title', '| Booking')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar-scheduler/1.9.4/scheduler.min.css'>
    <style>
        body {
            font-family: 'Noto Sans TC', sans-serif !important;
        }

        #calendar {
            -webkit-box-shadow: 0 0 0.8823em 0 rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0.8823em 0 rgba(0, 0, 0, 0.5);
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 40px;
            width: 100%;
        }


        #calendar .fc-past{
            background-color: #e8e8e8;
            border-color: #ddd;
        }

        #calendar .fc-highlight {
            background: #50e1ff;
            opacity: .4;
        }

        .fc-license-message {
            display: none !important;
        }

        .book_title {
            font-size: 19px;
        }

        .hotel_details {
            font-size: 17px;
            margin-top: 10px;
        }

        .book_btn a {
            width: 100%;
            font-family: 'Noto Sans TC', sans-serif !important;
        }

        .step-1, .step-2, .step-3, .step-4, .step-5 {
            margin-top: 20px;
            margin-bottom: 100px;
        }

        .step-2, .step-3, .step-4,.step-5 {
            display: none;
        }

        .book_row {
            border: 1px solid #dedede;
            background-color: white;
            box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
            color: #37454d;
            padding: 25px;
        }

        .book_person {
            margin-right: 10px;
        }

        .add_new_person {
            padding: 3px 10px 3px 10px !important;
            font-size: 13px !important;
            float: right;
            font-family: 'Noto Sans TC', sans-serif !important;
        }

        .step-1_next {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .add_error {
            display: none;
            background-color: rgba(255, 0, 0, 0.71);
            color: white;
            border-radius: 3px;
            width: 130px;
            text-align: center;
            padding: 3px;
        }

        .del_person {
            text-align: right;
        }

        .del_person_btn {
            float: right;
            background-color: rgba(255, 0, 0, 0.71);
            color: white;
            padding: 3px 10px 3px 10px;
            border-radius: 2px;
            cursor: pointer;
        }

        .step-2_btn_group {
            margin-top: 70px;
        }

        .name_error {
            margin-top: -15px;
            margin-bottom: 10px;
            color: red;
            display: none;
            font-size: 13px;
        }

        #total_price {
            font-size: 20px;
        }

        .no_date_error {
            margin-bottom: 30px;
            color: red;
            display: none;
        }
        
        .invalid_error{
            margin-bottom: 30px;
            color: red;
            display: none;
        }

        .arrival_notice {
            padding: 10px;
            margin-bottom: 40px;
            font-size: 17px;
            display: none;
        }

        .payment_method_error {
            display: none;
            color: red;
            margin-bottom: 10px;
        }

        .credit_card_form {
            display: none;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .credit_card_info {
            margin-top: 20px;
        }

        .person_info_field {
            margin-right: 10px;
            font-size: 17px;
        }

        .person_info i {
            font-size: 22px;
        }

        .person_info_title {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .progress {
            zoom: 90%;
            list-style: none;
            margin: 0;
            padding: 0;
            display: table;
            table-layout: fixed;
            width: 100%;
            color: #849397;
            background-color: transparent !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
            margin-top: 10px;
        }

        .progress > li {
            position: relative;
            display: table-cell;
            text-align: center;
            font-size: 0.8em;
        }

        .progress > li:before {
            content: attr(data-step);
            display: block;
            margin: 0 auto;
            background: white !important;
            width: 3em;
            height: 3em;
            text-align: center;
            margin-bottom: 0.25em;
            line-height: 3em;
            border-radius: 100%;
            position: relative;
            z-index: 1000;
            border: 5px solid #2d6098;
            color: white;
        }

        .progress > li:after {
            content: '';
            position: absolute;
            display: block;
            background: #DFE3E4;
            width: 100%;
            height: 0.5em;
            top: 1.25em;
            left: 50%;
            margin-left: 1.5em \9;
            z-index: -1;
        }

        .progress > li:last-child:after {
            display: none;
        }

        .progress > li.is-complete {
            color: #2d6098;
        }

        .progress > li.is-complete:before, .progress > li.is-complete:after {
            color: #FFF;
            background: #2d6098;
        }

        .progress > li.is-active {
            color: #3498DB;
        }

        .progress > li.is-active:before {
            color: #FFF;
            background: #3498DB;
        }

        /**
         * Needed for IE8
         */
        .progress__last:after {
            display: none !important;
        }

        /**
         * Size Extensions
         */
        .progress--medium {
            font-size: 1.5em;
        }

        .progress--large {
            font-size: 2em;
        }

        .progress {
            margin-bottom: 3em;
        }

        .lds-hourglass {
            display: inline-block;
            position: relative;
            /*width: 64px;*/
            /*height: 64px;*/
        }

        .lds-hourglass:after {
            content: " ";
            display: block;
            border-radius: 50%;
            width: 0;
            height: 0;
            margin: 6px;
            box-sizing: border-box;
            border: 50px solid #2d6098;
            border-color: #2d6098 transparent #5c7aff transparent;
            animation: lds-hourglass 3.2s infinite;
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

        .loading_shape{
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .personal_book{
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: right;
            padding-right: 10px;
            cursor: pointer;
        }
    </style>

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <ol class="progress progress--medium">
        <li class="is-active" data-step="1" id="progress_1">
            第一步
        </li>
        <li data-step="2" data-step="2" id="progress_2">
            第二步
        </li>
        <li data-step="3" data-step="" id="progress_3">
            第三步
        </li>
        <li data-step="4" data-step="" id="progress_4">
            第四步
        </li>
        <li data-step="5" class="progress__last" id="progress_5">
            完成
        </li>
    </ol>

    <div class="row step-1 book_row animated bounceInLeft">
        <div class="col-md-8">
            <div class="book_title">
                您正在預約 - <b>{{ $hotel->name }} - {{$room_type_list[$room->room_type_id]}}</b> <br><br>
                第一步 : 請填寫住客基本資料
            </div>
            <hr>

            {{ Form::open(['route' => ['hotel.booking', $hotel->id, $room->id], 'method' => 'POST' , 'id' => 'form_booking']) }}

            請填寫預約住客資料: <br>

            <div class="personal_book"><i class="fas fa-check-square"></i> 以會員個人資料作為住客資料</div>

            <div class="booking_form">
                <div class="row well book_person" id="new_1">
                    <div class="col-md-4">
                        <label for="title">名稱:<span style="color: red">*</span></label>
                        <input class="form-control" maxlength="255" name="name[]" type="text" id="name">
                        <div class="name_error">請填寫此項</div>
                    </div>
                    <div class="col-md-4">
                        <label for="phone">電話:</label>
                        <input class="form-control" maxlength="15" name="phone[]" type="text" id="phone">
                    </div>
                    <div class="col-md-4">
                        <label for="gender">性別:</label>
                        <div class="gender_box">
                            男性 <input name="gender1[]" type="radio" value="M" id="gender"
                                      data-parsley-multiple="gender">&nbsp;&nbsp;&nbsp;
                            女性 <input name="gender1[]" type="radio" value="F" id="gender"
                                      data-parsley-multiple="gender">
                            <br><br>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="email">電郵地址:</label>
                        <input class="form-control" maxlength="255" name="email[]" type="text" id="email">
                    </div>
                </div>
            </div>

            <div class="button button-3d button-action button-rounded add_new_person" onclick="addNewPerson()">
                新增一位住客
            </div>

            <div class="add_error animated flash">
                住客數目已達上限!
            </div>

            <span style="color: red">*</span> 星號為必填項目。
            <div class="book_btn step-1_next col-md-offset-7 col-md-4" onclick="stepTwo()">
                <a href="#" class="button button-3d button-primary button-rounded three_d_btn">下一步</a>
            </div>

        </div>
        <div class="col-md-4 well">
            @if($hotel->default_image != '')
                <img src="http://photo.hotellook.com/image_v2/limit/h{{$hotel['default_image']}}_0/640/480.jpg"
                     class="img-responsive">
            @else
                <img src="../../../images/upload/{{$hotel->image}}" class="img-responsive">
            @endif
            <div class="row hotel_details">
                <div class="col-md-4">
                    種類 -
                </div>
                <div class="col-md-7">
                    {{$room_type_list[$room->room_type_id]}}
                </div>
                <div class="col-md-4">
                    人數上限 -
                </div>
                <div class="col-md-7">
                    {{$room->ppl_limit}} 人
                </div>
                <div class="col-md-4">
                    價錢 -
                </div>
                <div class="col-md-7">
                    HKD ${{$room->price}} / 每晚
                </div>
            </div>
        </div>
    </div>



    <div class="row step-2 book_row animated bounceInRight">
        <div class="book_title">
            您正在預約 - <b>{{ $hotel->name }} - {{$room_type_list[$room->room_type_id]}}</b> <br><br>
            第二步 : 請拉選您的訂房日期
        </div>
        <hr>

        <div class="col-md-12">
            <div id="calendar"></div>
            <div class="no_date_error animated flash">
                請拉選您的訂房日期!
            </div>
            <div class="invalid_error">
                &nbsp;
            </div>
        </div>


        <div class="book_title">請檢查您所揀選的訂房日期及總價格</div>
        <br>

        <div class="row">
            <div class="col-md-6">
                <label for="in_date">入住日期:</label>
                <input class="form-control" maxlength="255" name="in_date" type="text" id="in_date"
                       readonly>
            </div>
            <div class="col-md-6">
                <label for="out_date">退房日期:</label>
                <input class="form-control" maxlength="255" name="out_date" type="text" id="out_date"
                       readonly>
            </div>
            <div class="col-md-6">
                <label for="single_price">酒店每晚收費</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input class="form-control" maxlength="255" name="single_price" type="text"
                           id="single_price" readonly value="{{$room->price}}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="handling_price">手續費</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input class="form-control" maxlength="255" name="handling_price" type="text"
                           id="handling_price" readonly value="0">
                </div>
            </div>
            <div class="col-md-12">
                <br>
                <label for="total_price" style="font-size: 20px">總收費</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input class="form-control" maxlength="255" name="total_price" type="text"
                           id="total_price" readonly>
                </div>
            </div>
        </div>

        <div class="row step-2_btn_group">
            <div class="col-md-offset-3 col-md-3 book_btn" onclick="stepOne()">
                <a href="#" class="button button-3d button-caution button-rounded three_d_btn">上一步</a>
            </div>

            <div class="col-md-3 book_btn" onclick="stepThree()">
                <a href="#" class="button button-3d button-primary button-rounded three_d_btn">下一步</a>
            </div>
        </div>

    </div>


    <div class="row step-3 book_row animated bounceInRight">
        <div class="book_title">
            您正在預約 - <b>{{ $hotel->name }} - {{$room_type_list[$room->room_type_id]}}</b> <br><br>
            第三步 : 請選擇付款方式及填寫資料
        </div>
        <hr>

        <label for="method">付款方式</label>
        <select class="form-control" name="payment_method" id="payment_method">
            <option value="" selected> -</option>
            @foreach($payment_method as $pay)
                <option value='{{ $pay->id }}'>{{ $pay->type }}</option>
            @endforeach
        </select>

        <div class="payment_method_error">
            請選擇付款方式
        </div>

        <div class="arrival_notice">
            您選擇了入住到付。<br>
            酒店會為您保留房間，且您無需於此刻付上房錢。<br>
            請您準時於入住日期到達酒店，並辦理入房手續。<br>
            謝謝。
        </div>

        <div class="credit_card_form">
            <div class="row">
                <div class="col-md-2 credit_card_img" style="text-align: center">
                    <img src="../../../images/visa.png">
                </div>
                <div class="col-md-6">
                    信用卡資料

                    <div class="credit_card_info well">
                        <label for="card_number">信用卡號碼</label>
                        <input class="form-control" maxlength="16" name="card_number" type="text"
                               id="card_number">

                        <div class="row">
                            <div class="col-md-6">
                                <div class='input-group'>
                                    <label for='expired_date'>到期日子</label>
                                    <input class="form-control" placeholder='' type='month' name="expired_date"
                                           id="expired_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="security_number">安全碼</label>
                                <input class="form-control" maxlength="3" name="security_number" type="text"
                                       id="security_number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row step-3_btn_group">
            <div class="col-md-offset-3 col-md-3 book_btn" onclick="stepTwo()">
                <a href="#" class="button button-3d button-caution button-rounded three_d_btn">上一步</a>
            </div>

            <div class="col-md-3 book_btn" onclick="stepFour()">
                <a href="#" class="button button-3d button-primary button-rounded three_d_btn">下一步</a>
            </div>
        </div>
    </div>


    <div class="row step-4 book_row animated bounceInRight">
        <div class="book_title">
            您正在預約 - <b>{{ $hotel->name }} - {{$room_type_list[$room->room_type_id]}}</b> <br><br>
            第四步 : 請確定您輸入的住客資料以及所有預約細節
        </div>
        <hr>

        <div class="well">
            住客資料<br><br>

            <div class="row person_info_title">
                <div class="col-md-offset-1 col-md-3">
                    <span class="person_info_field">名稱</span>
                </div>
                <div class="col-md-2">
                    <span class="person_info_field">電話</span>
                </div>
                <div class="col-md-2">
                    <span class="person_info_field">性別</span>
                </div>
                <div class="col-md-4">
                    <span class="person_info_field">電郵地址</span>
                </div>
            </div>

            <div class="row person_info">
                <div class="col-md-1">
                    <i class="fas fa-male"></i>
                </div>
                <div class="col-md-3">
                    <span class="person_info_field">  Ken</span>
                </div>
                <div class="col-md-2">
                    <span class="person_info_field">  22344567 </span>
                </div>
                <div class="col-md-2">
                    <span class="person_info_field">  男性</span>
                </div>
                <div class="col-md-4">
                    <span class="person_info_field">  ken@gmail.com </span>
                </div>
            </div>
        </div>

        <div class="well">
            <div class="row">
                <div class="col-md-6">
                    <label for="view_in_date">入住日期:</label>
                    <input type="text" class="form-control" name="view_in_date" id="view_in_date" readonly>
                </div>
                <div class="col-md-6">
                    <label for="view_out_date">退房日期:</label>
                    <input type="text" class="form-control" name="view_out_date" id="view_out_date" readonly>
                </div>
                <div class="col-md-6">
                    <label for="view_single_price">酒店每晚收費</label>
                    <input type="text" class="form-control" name="view_single_price" id="view_single_price" readonly>
                </div>
                <div class="col-md-6">
                    <label for="view_handling_price">手續費</label>
                    <input type="text" class="form-control" name="view_handling_price" id="view_handling_price" readonly>
                </div>
                <div class="col-md-12">
                    <label for="view_total_price" style="font-size: 20px">總收費</label>
                    <input type="text" class="form-control" name="view_total_price" id="view_total_price" readonly>
                </div>
                <div class="col-md-6">
                    <label for="view_payment_method">付款方式</label>
                    <input type="text" class="form-control" name="view_payment_method" id="view_payment_method" readonly>
                </div>
                <div class="col-md-6">
                    <label for="view_card_number">卡號</label>
                    <input type="text" class="form-control" name="view_card_number" id="view_card_number" readonly>
                </div>
            </div>
        </div>


        <div class="row step-4_btn_group">
            <div class="col-md-offset-3 col-md-3 book_btn" onclick="stepThree()">
                <a href="#" class="button button-3d button-caution button-rounded three_d_btn">上一步</a>
            </div>

            <div class="col-md-3 book_btn" onclick="stepFive()">
                <input class="button button-3d button-primary button-rounded three_d_btn" type="submit" value="確定付款及預約">
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="row step-5 book_row animated bounceInRight">
        <div class="book_title">
            您正在預約 - <b>{{ $hotel->name }} - {{$room_type_list[$room->room_type_id]}}</b> <br><br>
            最後一步 : 正在完成
        </div>
        <hr>

        <div class="loading_shape">
            <div class="lds-hourglass"></div><br><br>
            系統正在處理您的預約，請稍等。
        </div>
    </div>



@endsection


@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script>
        function stepOne() {
            $('.step-2').hide();
            $('.step-1').show();
        }

        var counter = 1;

        function addNewPerson() {
            var ppl_limit = '<?php echo $room->ppl_limit ?>';
            var form_html = $(".book_person").html();

            if (counter < ppl_limit) {
                counter++;
                $(".booking_form").append('<div class="row well book_person" id="new_' + counter + '">' + form_html + '<div class="col-md-12 del_person"><div class="del_person_btn" style="color: white" onclick="DeletePerson(' + counter + ')">刪除</div></div></div>');

                $("#new_" + counter + " #gender").attr('name', 'gender' + counter + '[]');
                $(".booking_form").css("color", "#37454d");

            } else {
                $(".add_error").show();
                setTimeout(function () {
                    $(".add_error").fadeOut();
                }, 2000);
            }

        }

        function DeletePerson(count) {
            $('#new_' + count).remove();
            counter--;
        }
    </script>

    <script>
        function ValidationForm() {

            var pass = true;

            $('.book_person #name').each(function (key, value) {
                //alert(this.value);
                var s_key = key + 1;

                if (this.value == '') {

                    $('#new_' + s_key + ' #name').addClass('parsley-error');
                    $('#new_' + s_key + ' .name_error').show();

                    $('#new_' + s_key + ' #name').focus();

                    setTimeout(function () {
                        $('#new_' + s_key + ' .name_error').fadeOut();
                    }, 1000);

                    $('#progress_1').addClass('is-active');
                    $('#progress_1').removeClass('is-complete');

                    pass = false;
                } else {
                    //alert(this.value);
                    $('#new_' + s_key + ' #name').removeClass('parsley-error');
                }
            });

            return pass;
        }

        function GetPersonData() {
            var person = [];
            $('.book_person #name').each(function (key, value) {
                person.push(this.value);
            });

            var phone = [];
            $('.book_person #phone').each(function (key, value) {
                if (this.value != '') {
                    phone.push(this.value);
                } else {
                    phone.push('沒有提供');
                }
            });

            var gender = [];
            $('.gender_box').each(function (key, value) {

                var sskey = key + 1;
                var gender_val = $("input[name='gender" + sskey + "[]']:checked").val();

                if (gender_val != undefined) {
                    var val = $(this).val();
                    gender.push(gender_val);
                } else {
                    gender.push('沒有提供');
                }
            });

            var email = [];
            $('.book_person #email').each(function (key, value) {
                if (this.value != '') {
                    email.push(this.value);
                } else {
                    email.push('沒有提供');
                }
            });


            $('.person_info').html('');
            for (i = 0; i < person.length; i++) {
                $('.person_info').append('                ' +
                    '                    <div class="col-md-1">\n' +
                    '                    <i class="fas fa-male"></i>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-3">\n' +
                    '                    <span class="person_info_field">' + person[i] + '</span>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-2">\n' +
                    '                    <span class="person_info_field">' + phone[i] + '</span>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-2">\n' +
                    '                    <span class="person_info_field">' + gender[i] + '</span>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-4">\n' +
                    '                    <span class="person_info_field">' + email[i] + '</span>\n' +
                    '                </div>');
            }

        }
    </script>


    <script>
        function stepTwo() {

            ValidationForm();
            GetPersonData();

            if (ValidationForm() == true) {
                $('.step-1').hide();
                $('.step-3').hide();
                $('.step-4').hide();

                $('.step-2').show();
                $(function () {
// grab focus so the binding below works
                    $(window).focus();

// used to track whether the user is holding the control key
                    var ctrlIsPressed = false;

                    function setEventsCopyable(isCopyable) {
                        ctrlIsPressed = !ctrlIsPressed;
                        $("#calendar").fullCalendar("option", "eventStartEditable", !isCopyable);
                        $(".fc-event").draggable("option", "disabled", !isCopyable);
                    }

// set events copyable if the user is holding the control key
                    $(document).keydown(function (e) {
                        if (e.ctrlKey && !ctrlIsPressed) {
                            setEventsCopyable(true);
                        }
                    });

// if control has been released stop events being copyable
                    $(document).keyup(function (e) {
                        if (ctrlIsPressed) {
                            setEventsCopyable(false);
                        }
                    });

                    var $calendar = $("#calendar").fullCalendar({
                        height: 500,
                        header: {center: 'basicWeek,timelineMonth,month,day'},
                        //defaultView: "timelineMonth",
                        defaultView: "month",
                        defaultDate: "<?php echo $today ?>",
                        dayClick: function () {
                            //alert('a day has been clicked!');
                        },
                        resourceColumns: [
                            {
                                labelText: 'Rome',
                                field: 'title',
                                width: 100
                            }

                        ],

                        resources: [
                            {id: "a", title: "Room A"},
                            {id: "b", title: "Room B", eventColor: "green"},
                            {id: "c", title: "Room C", eventColor: "orange"},
                            {id: "d", title: "Room D", eventColor: "red"}],

                        events: [
                            {
                                id: "1",
                                resourceId: "a",
                                start: "2018-04-06",
                                end: "2018-04-08",
                                title: "已沒供應"
                            },
//
                            {
                                id: "2",
                                resourceId: "a",
                                start: "2018-04-07T09:00:00",
                                end: "2018-04-08T14:00:00",
                                title: "event 2"
                            },

                            {
                                id: "3",
                                resourceId: "b",
                                start: "2018-04-07T12:00:00",
                                end: "2018-04-08T06:00:00",
                                title: "已沒供應"
                            },

                            {
                                id: "4",
                                resourceId: "c",
                                start: "2018-04-07T07:30:00",
                                end: "2018-04-07T09:30:00",
                                title: "event 4"
                            },

                            {
                                id: "5",
                                resourceId: "d",
                                start: "2018-04-07T10:00:00",
                                end: "2018-04-07T15:00:00",
                                title: "event 5"
                            }],

                        editable: false,
                        droppable: false,
                        selectable: true,
                        language: 'zh-tw',

                        eventClick: function (calEvent, jsEvent, view) {

//            alert('Event: ' + calEvent.title);
//            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//            alert('View: ' + view.name);

                            //alert(calEvent.id);
                            //alert(calEvent.start);

                            // change the border color just for fun
                            //$(this).css('border-color', 'red');

                        },

                        select: function (startDate, endDate) {

                            var check = startDate.format();
                            var d = new Date();

                            month = '' + (d.getMonth() + 1),
                            day = '' + d.getDate(),
                            year = d.getFullYear();

                            if (month.length < 2) month = '0' + month;
                            if (day.length < 2) day = '0' + day;

                            var today = year + "-" + month + "-" + day;

                            if(check < today)
                            {
                                alert('你不應選擇今日之前的日子!');
                            }

                            else {
                                var bookable = true;
                                
                                //ajax to check the supply of hotel room.... develop later...
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                
                                $.ajax({
                                    url: '../../checkvalidation',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        _token: CSRF_TOKEN,
                                        hotel_id: {{$hotel->id}},
                                        hotel_room_id: {{$room->id}},
                                        in_date: startDate.format(),
                                        out_date: endDate.format(),
                                    },
                                    dataType: 'JSON',
                                    beforeSend: function () {
                                        
                                    },
                                    success: function (data) {
                                        
                                        if(data['unavailable_array'] != ''){
                                            bookable = false;

                                            var html = '<b>以下日期之房間已滿，不能預約:</b>';
                                            $.each( data['unavailable_array'], function( key, value ) {
                                                //alert( key + ": " + value );
                                                html += '<div>'+value+'</div>';
                                            });

                                            $('.invalid_error').html(html);
                                            $('.invalid_error').fadeIn();
                                            
                                        } else {
                                            bookable = true;
                                            $('.invalid_error').fadeOut();
                                        }
                                    }
                                });

                                //alert('selected ' + startDate.format() + ' to ' + endDate.format());

                                if(bookable == true){
                                    $('#in_date').val(startDate.format());
                                    $('#out_date').val(endDate.format());

                                    var start = Date.parse(startDate.format());
                                    var end = Date.parse(endDate.format());
                                    var timeDiff = end - start;
                                    daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

                                    var single_price = $('#single_price').val();
                                    var handling_price = parseInt($('#handling_price').val());

                                    var total_price = (single_price * daysDiff) + handling_price;
                                    $('#total_price').val(total_price);
                                    
                                    $("html, body").animate({scrollTop: $(document).height()}, "slow");
                                } else {
                                    $('#in_date').val('');
                                    $('#out_date').val('');
                                    $('#total_price').val('');
                                    
                                    $("html, body").animate({scrollTop: $(document).height()}, "slow");
                                }
                            }
                        }

                    });

                });

                $('#progress_1').removeClass('is-active');
                $('#progress_1').addClass('is-complete');
                $('#progress_2').addClass('is-active');
            }
        }
    </script>

    <script>
        function ValidBooking() {
            var total_price = $('#total_price').val();

            if (total_price == '') {
                var step_2_pass = false;
            } else {
                var step_2_pass = true;
            }

            return step_2_pass;
        }
    </script>

    <script>
        function stepThree() {
            $('.step-4').hide();

            if (ValidBooking() == true) {
                $('.step-2').hide();
                $('.step-3').show();

                $('#progress_2').removeClass('is-active');
                $('#progress_2').addClass('is-complete');
                $('#progress_3').addClass('is-active');
            } else {
                $("html, body").animate({scrollTop: $(document).height()}, "slow");
                $('.no_date_error').show();
                setTimeout(function () {
                    $('.no_date_error').fadeOut();
                }, 1000);
            }

        }

        $("#payment_method").change(function () {

            var type = $(this).val();

            if (type == '5') {
                $('.arrival_notice').show();
                $('.credit_card_form').hide();
            } else {
                $('.arrival_notice').hide();
                $('.payment_method_error').hide();

                $('.credit_card_form').show();

                switch (type) {
                    case '':
                        $('.payment_method_error').show();
                        $('.credit_card_form').hide();
                        break;
                    case '1':
                        $('.credit_card_img').html('<img src="../../../images/visa.png">');
                        break;
                    case '2':
                        $('.credit_card_img').html('<img src="../../../images/mc.png">');
                        break;
                    case '3':
                        $('.credit_card_img').html('<img src="../../../images/amex.png">');
                        break;
                    case '4':
                        $('.credit_card_img').html('<img src="../../../images/discover.png">');
                        break;
                }
            }

        });

    </script>

    <script>
        function stepFour() {
            var type = $("#payment_method").val();

            if (type == '') {
                $('.payment_method_error').show();

                $('#progress_3').addClass('is-active');
                $('#progress_3').removeClass('is-complete');

            } else {

                $('#view_in_date').val($('#in_date').val());
                $('#view_out_date').val($('#out_date').val());
                $('#view_single_price').val($('#single_price').val());
                $('#view_handling_price').val($('#handling_price').val());
                $('#view_total_price').val($('#total_price').val());

                switch (type) {
                    case '1':
                        $('#view_payment_method').val('VISA');
                        break;
                    case '2':
                        $('#view_payment_method').val('Mastercard');
                        break;
                    case '3':
                        $('#view_payment_method').val('Amex');
                        break;
                    case '4':
                        $('#view_payment_method').val('Discover');
                        break;
                    case '5':
                        $('#view_payment_method').val('Pay on arrival 入住到付');
                        break;
                }

                if (type != '5') {
                    $('.payment_method_error').hide();

                    $('#view_card_number').val($('#card_number').val());

                    if ($('#card_number').val() == '' || $('#expired_date').val() == '' || $('#security_number').val() == '') {
                        $('.payment_method_error').show();
                        $('.payment_method_error').html('請填寫信用卡資料');
                        setTimeout(function () {
                            $('.payment_method_error').hide();
                            $('.payment_method_error').html('請選擇付款方式');
                        }, 1000);

                        $('#progress_3').addClass('is-active');
                        $('#progress_3').removeClass('is-complete');
                    } else {
                        $('#progress_3').removeClass('is-active');
                        $('#progress_3').addClass('is-complete');
                        $('#progress_4').addClass('is-active');

                        $('.step-3').hide();
                        $('.step-4').show();
                    }
                } else {
                    $('#progress_3').removeClass('is-active');
                    $('#progress_3').addClass('is-complete');
                    $('#progress_4').addClass('is-active');

                    $('.step-3').hide();
                    $('.step-4').show();
                }

            }
        }
    </script>


    <script>
        function stepFive() {
            $('html,body').animate({scrollTop: 0}, 'slow');

            $('.step-4').hide();
            $('.step-5').show();

            $('#progress_4').removeClass('is-active');
            $('#progress_4').addClass('is-complete');
            $('#progress_5').addClass('is-active');
        }


        //Prevent submit form by enter pass through validation
        $('#form_booking, .step-2 input, .step-3 input, .step-4 input').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

    </script>

    <script>
        var user_name = '{{$user->name}}';
        var user_phone = '{{$user->phone}}';
        var user_gender = '{{$user->gender}}';
        var user_email = '{{$user->email}}';

        $(".personal_book").click(function(){
            $('#new_1 #name').val(user_name);
            $('#new_1 #phone').val(user_phone);
            $('#new_1 #email').val(user_email);

            $('#new_1 .gender_box').each(function (key, value) {
                $("#new_1 input[value=" + user_gender + "]").attr('checked', 'checked');
            });
        });
        
        $("#handling_price").val({{$hotel->handling_price}});
    </script>


    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://code.jquery.com/ui/1.11.3/jquery-ui.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar-scheduler/1.9.4/scheduler.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/zh-tw.js"></script>
    <script>

    </script>

@endsection
