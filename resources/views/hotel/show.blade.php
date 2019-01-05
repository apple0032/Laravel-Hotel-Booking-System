@extends('index')

@section('title', '- '. $hotel->name)

@php
    use Illuminate\Support\Facades\Input;
@endphp

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}

@endsection
<style>
    body {
        background-color: #ebeced !important;
    }

    .navbar {
        margin-bottom: 0px !important;
    }

    .search_box {
        margin-bottom: 40px;
        margin-left: 30%;
        margin-right: 30%;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .search_container {
        background-image: url("images/italy.jpg");
        background-attachment: fixed;
        background-size: cover; /* <------ */
        background-repeat: no-repeat;
        background-position: center bottom;
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
            margin-left: 20%;
            margin-right: 20%;
        }
    }

    .btn-action {
        border-color: #d4a900 #aa8700 #aa8700;
        background: #ffbe00;
        background: -webkit-gradient(linear, left bottom, left top, from(#ffbe00), to(#ffcb00));
        background: linear-gradient(to top, #ffbe00 0, #ffcb00 100%);
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

    .search_container .form-control {
        margin-bottom: 7px;
    }

    .noUi-connect {
        background: #4398e9 !important;
    }

    .hotel_grid_index {
        padding-left: 40px !important;
        padding-right: 40px !important;
    }

    .hotel_grid {
        font-family: 'Noto Sans TC', sans-serif !important;
        background-color: white;
        box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
        color: #37454d;
        margin-bottom: 10px;
    }

    .hotel_grid_image {
        padding: 0px !important;
    }

    .hotel_grid_image img {
        /*height: auto;*/
        /*width: 100%;*/
        height: 245px;
        width: 280px;
    }

    @media (max-width: 900px) {
        .hotel_grid_image img {
            height: auto;
            width: 100%;
        }
    }

    .hotel_grid_info {
        margin-bottom: 10px;
    }

    .hotel_grid_info span {
        background-color: #ebebeb;
        border-radius: 5px;
        padding-right: 6px;
        padding-left: 6px;
        margin-top: 5px;
    }

    .hotel_grid_info a {
        color: #37454d;
    }

    .hotel_grid_info a:hover {
        color: #fff;
        transition: all .2s;
    }

    .hotel_grid_info span:hover {
        background-color: #4398e9;
    }

    .hotel_grid_facility {
        margin-top: 30px;
    }

    .hotel_grid_facility i {
        font-size: 16px;
        margin-right: 10px;
    }

    .hotel_grid_infobox {
        border-right: 1px solid #eee;
        margin-top: 5px;
    }

    .hotel_grid_room {
        height: 230px;
    }

    @media (max-width: 768px) {
        .hotel_grid_room {
            height: 200px;
            margin-bottom: 10px;
        }
    }

    .hotel_grid_roombox {
        background-color: #285e92;
        color: white;
        margin-bottom: 3px;
        padding: 10px;
        border-radius: 1px;
    }

    .hotel_grid_btn {
        text-align: center;
        width: 90%;
        margin-top: 30px;
        float: right;
        padding: 10px 30px 10px 30px;
        background-color: #428500;
        border: 1px solid #428500;
        border-bottom: 1px solid #316300;
        margin-bottom: 10px;
        position: absolute;
        bottom: 0;
    }

    .hotel_grid_btn:hover {
        background-color: #52b700;
    }

    .hotel_grid_btn a {
        color: white;
    }

    .hotel_grid_btn a:hover {
        text-decoration: none;
        color: white;
    }

    .hotel_grid_container {
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .small_search_container {
        padding: 5px 30px 0px 30px;
        height: 80px;
        background-color: #37454d;
        margin-bottom: 25px;
        width: 100%;
        z-index: 100 !important;
        color: white;
    }

    .small_search_index {
        background-color: #37454d;
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
        font-size: 110px;
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

    .loading_icon {
        display: none;
        margin-top: 20px;
        margin-bottom: 20px;
        text-align: center;
    }

    .lds-roller {
        display: inline-block;
        position: absolute;
        z-index: 100;
        width: 64px;
        height: 64px;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 32px 32px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #000;
        margin: -3px 0 0 -3px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 50px;
        left: 50px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 54px;
        left: 45px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 57px;
        left: 39px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 58px;
        left: 32px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 57px;
        left: 25px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 54px;
        left: 19px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 50px;
        left: 14px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 45px;
        left: 10px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .total_result {
        margin-left: 10px;
        margin-top: 5px;
        margin-bottom: 20px;
        font-size: 16px;
        font-weight: bold;
        font-family: 'Kanit', sans-serif;
    }

    .total_result span {
        color: red;
    }

    .result_mainpage {
        margin-top: -30px;
    }

    .scrolltop {
        display: none;
        width: 100%;
        margin: 0 auto;
        position: fixed;
        bottom: 70px;
        right: 10px;
        z-index: 2;
    }

    .scroll {
        position: absolute;
        right: 20px;
        bottom: 20px;
        background: #b2b2b2;
        background: rgba(178, 178, 178, 0.7);
        padding: 20px;
        text-align: center;
        margin: 0 0 0 0;
        cursor: pointer;
        transition: 0.5s;
        -moz-transition: 0.5s;
        -webkit-transition: 0.5s;
        -o-transition: 0.5s;
        z-index: 2;
    }

    .scroll:hover {
        background: rgba(178, 178, 178, 1.0);
        transition: 0.5s;
        -moz-transition: 0.5s;
        -webkit-transition: 0.5s;
        -o-transition: 0.5s;
    }

    .scroll:hover .fa {
        padding-top: -10px;
    }

    .scroll .fa {
        font-size: 30px;
        margin-top: 5px;
        margin-left: 1px;
        transition: 0.5s;
        -moz-transition: 0.5s;
        -webkit-transition: 0.5s;
        -o-transition: 0.5s;
    }

    .button-3d {
        position: absolute !important;
        border-radius: 5px;
        height: 50px;
    }

    .scrolltop .button {
        padding: 0 30px !important;
    }

    @media (max-width: 990px) {
        .hotel_page {
            margin-top: 360px;
        }
    }

    @media (max-width: 400px) {
        .hotel_page_img {
            width: 1200px !important;
            height: 200px !important;
        }
    }

    .hotel_page_header {
        font-family: "Noto Sans TC", sans-serif;
        font-size: 27px;
        margin-bottom: 10px;
    }

    .hotel_page_header i {
        font-size: 20px;
        margin-right: -5px;
    }

    .hotel_page_img {
        width: 1200px;
        height: 500px !important;
    }

    .hotel_page_map, .hotel_page_details, .hotel_page_body_b, .hotel_page_comment {
        border: 3px solid #37454d;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .hotel_page_map {
        padding: 0 !important;
        height: 220px;
    }

    .hotel_page_map_header, .hotel_page_details_header, .hotel_page_body_header {
        background-color: #37454d;
        color: white;
        font-family: "Noto Sans TC", sans-serif;
        font-size: 19px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        padding-top: 3px;
        padding-bottom: 3px;
    }

    .hotel_page_details_header {
        margin-top: 20px;
    }

    .hotel_page_details {
        font-size: 18px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .hotel_page_details_info span {
        background-color: #cbcbcb;
        border-radius: 5px;
        padding-right: 6px;
        padding-left: 6px;
        margin-top: 5px;
        font-size: 14px;
        margin-right: -2px;
    }

    .hotel_page_details_info a {
        color: #37454d;
    }

    .hotel_page_details_info a:hover {
        color: #fff;
        transition: all .2s;
    }

    .hotel_page_details_info span:hover {
        background-color: #4398e9;
    }

    .hotel_page_fac {
        margin-top: 25px;
    }

    .hotel_page_fac i {
        margin-right: 5px;
    }

    .hotel_page_body {
        min-height: 100px;
        margin-top: 20px;
    }

    @media (min-width: 990px) {
        .hotel_page_body_header {
            margin-left: 15px;

        }

        .hotel_page_body_b {
            margin-left: 15px;
        }

        .hotel_page_body {
            padding-right: 15px;
        }

        .hotel_page_comment {
            margin-left: 15px;
        }
    }

    .hotel_page_body_b {
        padding: 15px;
        margin-bottom: 10px;
    }

    .hotel_page_room {
        margin-bottom: 0px;
    }

    .hotel_room_box {
        margin-bottom: 0px !important;
    }

    .hotel_room_detail .title {
        font-size: 22px;
    }

    .hotel_page_room_price {
        text-align: right;
        font-size: 25px;
        font-weight: bold;
        margin-top: 30px;
        margin-right: 30px;
    }

    .hotel_page_room_price span {
        font-size: 13px;
    }

    @media (min-width: 990px) {
        .hotel_page_room_book {
            margin-top: 110px;
            margin-right: 30px;
            text-align: right;
        }
    }

    @media (max-width: 990px) {
        .hotel_page_room_book {
            margin-bottom: 30px;
            margin-left: 30px;
        }

        .hotel_page_room_price {
            margin-top: 60px;
        }
    }

    .hotel_page_room_book span {
        padding: 10px 30px 10px 30px;
        background-color: #285e92;
        font-size: 17px;
    }

    .hotel_page_room_book a {
        text-decoration: none;
        color: white;
    }

    .hotel_page_room_book a:hover {
        color: #84cbff;
    }

    .hotel_room_detail i {
        margin-top: 25px !important;
    }

    .hotel_room_promo {
        border: 5px solid rgba(231, 84, 95, 0.77) !important;
        box-shadow: none !important;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .hotel_room_promo_header {
        background-color: rgba(231, 84, 95, 0.77);
        padding: 2px 5px 2px 5px;
        color: white;
        font-size: 20px;
        font-family: "Noto Sans TC", sans-serif;
    }

    @media (max-width: 990px) {
        .hotel_grid_container {
            margin-top: 340px;
        }

        .hotel_page_hotelname {
            display: block;
        }
    }

    .comment_left, .comment_right {
        margin: 0px;
        padding: 20px;
    }

    .comment_left {
        background-color: #51666e;
        text-align: center;
    }

    .comment_right {
        text-align: left;
        font-size: 17px;
        color: #51666e;
    }

    .hotel_page_comment {
        color: white;
        background-color: white;
    }

    .comment_left i {
        display: block;
        font-size: 50px;
        margin-bottom: 5px;
    }

    .hotel_comment_each {
        border: 2px solid white;
        border-bottom: 2px solid #bfbfbf;
        margin-bottom: 15px;
    }

    .hotel_comment_star {
        border-top: 2px solid #dde4df;
        color: black;
    }

    .no_comment {
        padding: 15px;
        padding-left: 0px;
        color: #333;
    }

    .comment_star {
        color: #636363;
        padding-top: 5px;
        text-align: right;
    }

    .comment_star span {
        font-size: 35px;
        font-style: italic;
    }

    .comment_each {
        border-bottom: 2px solid #d5d5d5;
    }

    .guest_rating {
        font-family: 'Noto Sans TC', sans-serif !important;
        font-size: 25px;
        text-align: right;
        margin-bottom: 15px;
    }

    .rating {
        border: none;
        float: left;
        width: 100%;
        background-color: white;
    }

    .rating > input {
        display: none;
    }

    .rating > label:before {
        margin: 5px;
        font-size: 1.5em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }

    .rating > .half:before {
        content: "\f089";
        position: absolute;
    }

    .rating > label {
        color: #ddd;
        float: right;
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
    .rating:not(:checked) > label:hover, /* hover current star */
    .rating:not(:checked) > label:hover ~ label {
        color: #FFD700;
    }

    /* hover previous stars in list */

    .rating > input:checked + label:hover, /* hover current star when changing rating */
    .rating > input:checked ~ label:hover,
    .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
    .rating > input:checked ~ label:hover ~ label {
        color: #FFED85;
    }

    .hotel_grid_rating{
        font-size:13px;
        padding-top: 15px;
        padding-right: 0px !important;
    }

    .hotel_grid_rating span{
        font-style: italic;
        font-size: 24px;
        color: red;
        font-weight: bold;
    }
</style>


<meta name="csrf-token" content="{{ csrf_token() }}"/>


@section('content')
    <div class="small_search_container">
        <div class="row">
            {!! Form::open(array('route' => 'pages.search', 'data-parsley-validate' => '')) !!}

            <div class="row small_search_index">
                <div class="col-md-2">
                    {{ Form::label('name', '酒店名稱') }}
                    {{ Form::text('name', null, array('class' => 'form-control', 'maxlength' => '255')) }}
                </div>
                <div class="col-md-2">
                    {{ Form::label('category_id', '酒店類型') }}
                    <select class="form-control" name="category_id" id="cate">
                        <option value="" selected> -</option>
                        @foreach($categories as $category)
                            <option value='{{ $category->id }}'>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    {{ Form::label('star', '星級') }}
                    <select class="form-control" name="star" id="star">
                        <option value="" selected> -</option>
                        @foreach($stars as $star)
                            <option value='{{ $star }}'>{{ $star }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    {{ Form::label('tags', '標籤') }}
                    <select class="form-control select2-multi" name="tags[]" multiple="multiple" id="tags"
                            style="width:100%">
                        @foreach($tags as $tag)
                            <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    {{ Form::label('rome_type','房類') }}
                    <select class="form-control" name="room_type" id="room_type">
                        <option value="" selected> -</option>
                        @foreach($room_types as $room_type)
                            <option value='{{ $room_type['id'] }}'>{{ $room_type['type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    {{ Form::label('people_limit', '人數') }}
                    <select class="form-control" name="people_limit" id="people_limit">
                        <option value="" selected> -</option>
                        @foreach($people_limits as $people_limit)
                            <option value='{{ $people_limit }}'>{{ $people_limit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
@endsection



@section('content.grid')

    <div class="loading_icon">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="row hotel_page">
        <div class="col-md-8">
            <div class="hotel_page_header">

                <span class="hotel_page_hotelname">{{$hotel->name}}</span>

                <?php for ($x = 0; $x < $hotel->star; $x++) { ?>
                <i class="fas fa-star" style="color: #f6ab3f"></i>
                <?php } ?>

            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    @if($hotel->new != 1)
                        @if($hotel->allimage != null)
                            <?php for ($x = 1; $x < count($hotel->allimage) + 6 ; $x++) { ?>
                            <li data-target="#myCarousel" data-slide-to="{{$x}}"></li>
                            <?php } ?>
                        @endif
                    @else
                        @if($hotel->allimage != null)
                            <?php for ($x = 1; $x < count($hotel->allimage) + 1 ; $x++) { ?>
                            <li data-target="#myCarousel" data-slide-to="{{$x}}"></li>
                            <?php } ?>
                        @endif
                    @endif
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    @if($hotel->image != 'null.jpg')
                        <div class="item active">
                            <img src="{{asset('/images/upload/'.$hotel->image)}}" class="hotel_page_img">
                        </div>
                    @else
                        <div class="item active">
                            <img src="http://photo.hotellook.com/image_v2/limit/h{{$hotel['default_image']}}_0/750/480.jpg">
                        </div>
                    @endif

                    @if($hotel->new != 1)
                        <?php for ($x = 1; $x <= 5; $x++) { ?>
                        <div class="item">
                            <img src="http://photo.hotellook.com/image_v2/limit/h{{$hotel['default_image']}}_<?= $x ?>/750/480.jpg">
                        </div>
                        <?php } ?>
                    @endif

                    @if($hotel->allimage != null)
                        @foreach($hotel->allimage as $img)
                            <div class="item">
                                <img src="{{asset('/images/upload/'.$img->filename)}}" class="hotel_page_img">
                            </div>
                        @endforeach
                    @endif

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4" style="">

            <div class="guest_rating">
                @if($rate != null)
                    住客評分
                    {{$rate}}
                    <i class="fas fa-star" style="color: #f6ab3f"></i>
                @else
                    &nbsp;
                @endif
            </div>

            <div class="row">
                <div class="col-md-12 hotel_page_map_header">
                    地圖資訊
                </div>
                <div class="col-md-12 hotel_page_map">
                    {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.413458239054!2d135.50489658989676!3d34.64425983896942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000dd8cdc9ce6e5%3A0xd69089cb53b573b0!2z6aOb55Sw5paw5Zyw5paZ55CG57WE5ZCI!5e0!3m2!1szh-TW!2shk!4v1542998231642"--}}
                    {{--frameborder="1" style="border:0; width: 100%; height: 100%" allowfullscreen></iframe>--}}
                    @if($hotel->coordi_x != null)
                        <iframe width="100%" height="100%" id="gmap_canvas"
                                src="https://maps.google.com/maps?q={{$hotel->coordi_x}}%2C{{$hotel->coordi_y}}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

                    @else
                        <iframe width="100%" height="100%" id="gmap_canvas"
                                src="https://maps.google.com/maps?q=22.4232475954273%2C114.23137664794923&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    @endif
                </div>
                <div class="col-md-12 hotel_page_details_header">
                    酒店資訊
                </div>
                <div class="col-md-12 hotel_page_details">
                    <div class="hotel_page_details_info" style="font-size: 22px; margin-bottom: 5px">
                        {{$hotel->name}}
                    </div>
                    <div class="hotel_page_details_info">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="col-md-11">
                                {{$hotel->phone}}
                            </div>
                        </div>
                    </div>
                    <div class="hotel_page_details_info">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div class="col-md-11">
                                {{$cat_list[$hotel->category_id]}}
                            </div>
                        </div>
                    </div>
                    <div class="hotel_page_details_info">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="col-md-11">
                                @foreach($hotel->posttag as $tag)
                                    <span><a href="../search?tags%5B0%5D={{$tag->tag_id}}">{{ucwords($tag_list[$tag->tag_id])}}</a></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="hotel_page_details_info hotel_page_fac">
                        @foreach($hotel_facility_list as $key => $hotel_fac)
                            @if($hotel->facility[$hotel_fac] == 1)
                                <i class="fas {{$hotel_fontawesome[$key]}}" data-toggle="tooltip"
                                   title="{{$hotel_facility_label[$key]}}"></i>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row hotel_page_body">
        <div class="col-md-12 hotel_page_body_header">
            酒店簡介
        </div>
        <div class="col-md-12 hotel_page_body_b">
            @if($hotel->body != null)
                <?php print_r($hotel->body) ?>
            @else
                暫沒有簡介
            @endif
        </div>
    </div>

    <div class="row hotel_page_body hotel_page_room">
        <div class="col-md-12 hotel_page_body_header">
            房間資料
        </div>
        <div class="col-md-12 hotel_page_body_b">
            @if(count($hotel->room) > 0)
                @foreach($hotel->room as $room)

                    @if($room->availability == 1)
                        @if($room->promo == 1)
                            <div class="hotel_room_promo_header">限時優惠</div>
                        @endif
                        <div class="hotel_room_box @if($room->promo == 1) {{'hotel_room_promo'}} @endif">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                    switch ($room->room_type_id) {
                                        case 1:
                                            $room_img = 'normal';
                                            break;
                                        case 2:
                                            $room_img = 'epic';
                                            break;
                                        case 3:
                                            $room_img = 'legend';
                                            break;
                                    }
                                    ?>

                                    <img src="{{asset("/images/$room_img.jpg")}}" class="img-responsive">

                                </div>
                                <div class="col-md-3 hotel_room_detail">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="title"> 種類:</div>
                                            人數上限:<br>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="title">
                                                {{$room_type_list[$room->room_type_id]}}<br>
                                            </div>
                                            {{$room->ppl_limit}}人<br>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 90px">
                                        <div class="col-md-12">
                                            @foreach($room_facility_list as $key =>$fac)
                                                @if($room->facility[$fac] == 1)
                                                    <i class="fas {{$temp_fontawesome[$key]}}" data-toggle="tooltip"
                                                       title="{{$room_facility_label[$key]}}"></i>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="hotel_page_room_price">
                                        HKD ${{$room->price}} <span>/ 每晚</span>
                                    </div>
                                    <div class="hotel_page_room_book">
                                        <span>
                                            <a href="{{$hotel->id}}/book/{{$room->id}}">選擇</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                此酒店暫沒有任何房間供應。
            @endif
        </div>
    </div>

    <style>

    </style>

    <div class="row hotel_page_body" style="margin-bottom: 20px">
        <div class="col-md-12 hotel_page_body_header">
            住客留名
        </div>
        <div class="col-md-12 hotel_page_comment">
            @if($hotel->comment->count() != 0)
                @foreach($hotel->comment as $comment)
                    <div class="row comment_each">
                        <div class="col-md-2 comment_left">
                            <i class="fas fa-user-tie"></i>
                            {{$user_list[$comment->user_id]}}
                        </div>
                        <div class="col-md-8 comment_right">
                            {{$comment->comment}}
                        </div>
                        <div class="col-md-2 comment_star">
                            <span>{{$comment->star}}</span> &nbsp;
                            <i class="fas fa-star" style="color: #f6ab3f; font-size:25px;"></i>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no_comment"> 暫沒有任何留言</div>
            @endif
        </div>
    </div>

    {{--@foreach($hotel->comment as $comment)--}}
    {{--User = {{$user_list[$comment->user_id]}}<br>--}}
    {{--Comment = {{$comment->comment}}<br>--}}
    {{--<br>--}}
    {{--@endforeach--}}


    <form method="POST" action="../comment/{{$hotel->id}}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <textarea rows="4" cols="50" class="form-control" name="comment" id="comment" placeholder="留下評論"></textarea>

        <fieldset class="rating">
            <input type="radio" id="star5" name="rating" value="5"/><label class="full" for="star5"
                                                                           title="Awesome - 5 stars"></label>
            <input type="radio" id="star4half" name="rating" value="4.5"/><label class="half" for="star4half"
                                                                                 title="Pretty good - 4.5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4"/><label class="full" for="star4"
                                                                           title="Pretty good - 4 stars"></label>
            <input type="radio" id="star3half" name="rating" value="3.5"/><label class="half" for="star3half"
                                                                                 title="Meh - 3.5 stars"></label>
            <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3"
                                                                           title="Meh - 3 stars"></label>
            <input type="radio" id="star2half" name="rating" value="2.5"/><label class="half" for="star2half"
                                                                                 title="Kinda bad - 2.5 stars"></label>
            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                           title="Kinda bad - 2 stars"></label>
            <input type="radio" id="star1half" name="rating" value="1.5"/><label class="half" for="star1half"
                                                                                 title="Meh - 1.5 stars"></label>
            <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1"
                                                                           title="Sucks big time - 1 star"></label>
            <input type="radio" id="starhalf" name="rating" value="0.5"/><label class="half" for="starhalf"
                                                                                title="Sucks big time - 0.5 stars"></label>
        </fieldset>

        <br><br><br>

        <input onclick="this.style.backgroundColor = '#69c061';" type="submit" value="發表" style="color:black">
    </form>
    <br><br>


    <div class='scrolltop'>
        <div class='scroll icon button button-3d button-primary'><i class="fa fa-4x fa-angle-up"></i></div>
    </div>
@endsection

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
        $('[data-toggle="tooltip"]').tooltip();
    </script>

    <script>
        $(".small_search_container input[name='name'],.small_search_container select[name='category_id'], .small_search_container select[name='star'], .small_search_container #tags, .small_search_container select[name='room_type'], .small_search_container select[name='people_limit']").change(function () {

            var name = $("input[name='name']").val();
            name = name.replace(/ /g, "|");

            var category = $("select[name='category_id'] option:selected").val();
            var star = $("select[name='star'] option:selected").val();
            var room_type = $("select[name='room_type'] option:selected").val();
            var ppl = $("select[name='people_limit'] option:selected").val();
            var tags = $("#tags").val();
            SearchByAjax(name, category, star, room_type, ppl, tags);
        });

        function SearchByAjax(name, category, star, room_type, ppl, tags) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'searchbyajax',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    name: name,
                    category: category,
                    star: star,
                    room_type: room_type,
                    ppl: ppl,
                    tags: tags
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $('.loading_icon').show();
                    $(".container").css("opacity", "0.4");
                },
                success: function (data) {
                    $('.loading_icon').hide();
                    $(".container").css("opacity", "1");

                    $('.total_result').remove();
                    $('.hotel_grid_index').remove();
                    $('.hotel_page').remove();
                    //console.log(data);
                    //console.log(tags);

                    var etag = '';
                    if (tags) {
                        for (i = 0; i < tags.length; i++) {
                            etag += '&tags[' + i + ']=' + tags[i];
                        }
                    } else {
                        etag = '';
                    }

                    //console.log(etag);
                    name = name.split("|").join("%20");

                    $('.container').load('../search?name=' + name + '&category=' + category + etag + '&star=' + star + '&room_type=' + room_type + '&people_limit=' + ppl + '&price_low=&price_up=&page=1 .hotel_grid_container', function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                }
            });
        }

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrolltop:hidden').stop(true, true).fadeIn();
            } else {
                $('.scrolltop').stop(true, true).fadeOut();
            }
        });

        $(".scroll").click(function () {
            $('html,body').animate({scrollTop: 0}, 'slow');
        })

    </script>

@endsection