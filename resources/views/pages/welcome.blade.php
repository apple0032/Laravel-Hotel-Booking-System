@extends('index')

@php
    use Illuminate\Support\Facades\Input;
@endphp

@if($search_small == true)
    @section('title', '- Hotels')
@else
    @section('title', '- Main')
@endif

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
        margin-left: 20%;
        margin-right: 20%;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .search_container {
        background-image: url("images/italy.jpg");
        background-attachment: fixed;
        background-size: cover; /* <------ */
        background-repeat: no-repeat;
        background-position: center bottom;
        transition: background-color 3s linear !important;
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
        margin-bottom: 55px;
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

    .button-3d{
        position: absolute !important;
        border-radius: 5px;
        height: 50px;
    }

    .scrolltop .button{
        padding: 0 30px !important;
    }

    @media (min-width: 990px) {
        .list-unstyled {
            position: absolute;
            z-index: 10;
            background-color: white;
            /*display: none;*/
            margin-top: -7px;
        }
    }

    @media (max-width: 990px) {
        .list-unstyled {
            display:none;
        }
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

    .nopadding{
        padding-right: 0px !important;
    }

    .nopadding-left{
        padding-left: 0px !important;
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

    .daterangepicker td.in-range {
        background-color: #ebf4f8 !important;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}"/>

@if($search_small == true)
    <style>
        @media (max-width: 992px) {
            .hotel_grid_container {
                margin-top: 380px;
            }
        }
    </style>
@endif

@section('content')
    @if($search_small == false)
        <div class="search_container">
            <div class="search_box">
                <div class="row search_index">
                    <div class="col-md-12">
                        {!! Form::open(array('route' => 'pages.search', 'data-parsley-validate' => '')) !!}

                        <div class="row">
                            <div class="col-md-3 search_hotelname">
                                {{ Form::label('name', 'Name -') }}
                                <input class="form-control" maxlength="200" name="name" type="text"
                                       id="search_hotelname">
                                <ul class="list-unstyled">
                                    {{--<li class="search_opt" value="value1">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-3 nopadding">--}}
                                                {{--<img src="images/epic.jpg" style="width:60px; height:40px; margin-right: 8px;">--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-9 nopadding-left">--}}
                                                {{--Bayshore Inn - Double Room with open view Balcony P9--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li class="search_opt" value="value2">Option 2</li>--}}
                                    {{--<li class="search_opt" value="value3">Option 3</li>--}}
                                </ul>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('category_id', 'Category -') }}
                                <select class="form-control" name="category_id">
                                    <option value="" selected> -</option>
                                    @foreach($categories as $category)
                                        <option value='{{ $category->id }}'>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('star', 'Star -') }}
                                <select class="form-control" name="star">
                                    <option value="" selected> -</option>
                                    @foreach($stars as $star)
                                        <option value='{{ $star }}'>{{ $star }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('tags', 'Tags -') }}
                                <select class="form-control select2-multi" name="tags[]" multiple="multiple"
                                        style="width:100%">
                                    @foreach($tags as $tag)
                                        <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                {{ Form::label('rome_type','Room Type -') }}
                                <select class="form-control" name="room_type">
                                    <option value="" selected> -</option>
                                    @foreach($room_types as $room_type)
                                        <option value='{{ $room_type['id'] }}'>{{ $room_type['type'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('people_limit', 'People -') }}
                                <select class="form-control" name="people_limit">
                                    <option value="" selected> -</option>
                                    @foreach($people_limits as $people_limit)
                                        <option value='{{ $people_limit }}'>{{ $people_limit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('Date', 'Date - ') }}
                                <input class="form-control" type="text" name="daterange" id="daterange" value="" readonly/>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('Price', 'Price - ') }}
                                <div id="slider"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="Price" style="display: block">Range - </label>
                                <input class="form-control" maxlength="255" name="price_lower" type="text"
                                       id="price_lower"
                                       style="height: 20px; width:45%; display: inline-block">
                                <i class="fas fa-window-minimize" style="font-size: 16px;"></i>
                                <input class="form-control" maxlength="255" name="price_upper" type="text"
                                       id="price_upper"
                                       style="height: 20px; width:45%; display: inline-block">
                            </div>
                        </div>

                        {{ Form::submit('SEARCH', array('class' => 'btn btn-action', 'style' => 'margin-top: 20px;')) }}
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    @else
        @php
            $selected_tags = Input::get('tags');
        @endphp
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
                            @if($selected_tags == null)
                                @foreach($tags as $tag)
                                    <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                                @endforeach
                            @else
                                @foreach($tags as $tag)
                                    @foreach($selected_tags as $stags)
                                        <option value='{{ $tag->id }}' <?php
                                            if ($stags == $tag->id) {
                                                echo 'selected';
                                            }
                                            ?> >{{ $tag->name }}</option>
                                    @endforeach
                                @endforeach
                            @endif
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
    @endif
@endsection

@section('content.grid')
    <div class="row">
        @if($search_small == true)

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

        @endif
        <div class="col-md-12 hotel_grid_container">
            @if($hotels != null)
                @if($search_small == true)
                    <div class="total_result">
                        <i class="fas fa-search"></i> Totally <span>{{$hotels->total()}}</span> of hotels found.
                    </div>
                @else
                    <div class="total_result result_mainpage">
                        <i class="fas fa-list"></i> Showing RANDOM five hotels.
                    </div>
                @endif
                @foreach($hotels as $k => $hotel)

                    <div class="row ajax_load_hotel">
                        <div class="col-md-12 hotel_grid_index">
                            <div class="row hotel_grid">
                                <div class="col-md-3 hotel_grid_image">
                                    @if($hotel['image'] != 'null.jpg')
                                        <img src="{{url('/')}}/images/upload/{{$hotel['image']}}"
                                             class="img-responsive">
                                    @else
                                        <img src="http://photo.hotellook.com/image_v2/limit/h{{$hotel['default_image']}}_0/640/480.jpg"
                                             class="img-responsive">
                                    @endif
                                </div>
                                <div class="col-md-5 hotel_grid_infobox">
                                    <h3>{{$hotel['name']}}</h3>
                                    <?php for ($x = 0; $x < $hotel['star']; $x++) { ?>
                                    <i class="fas fa-star" style="color: #f6ab3f"></i>
                                    <?php } ?>
                                    <hr>
                                    <div class="hotel_grid_info">
                                        <i class="fas fa-hotel"></i> {{$cat_list[$hotel['category_id']]}}
                                    </div>
                                    <div class="hotel_grid_info">
                                        <i class="fas fa-tags"></i>
                                        @foreach($hotel->posttag as $tag)
                                            <span><a href="search?tags%5B0%5D={{$tag->tag_id}}">{{ucwords($tag_list[$tag->tag_id])}}</a></span>
                                        @endforeach
                                    </div>
                                    <div class="hotel_grid_facility">
                                        @foreach($hotel_facility_list as $key => $hotel_fac)
                                            @if($hotel->facility[$hotel_fac] == 1)
                                                <i class="fas {{$hotel_fontawesome[$key]}}" data-toggle="tooltip"
                                                   title="{{$hotel_facility_label[$key]}}"></i>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-1 hotel_grid_rating">
                                    住客評分<br>
                                    @if($rate[$k] != null)
                                        <span>{{$rate[$k]}}</span> / 5
                                    @else
                                        <span>0</span> / 5
                                    @endif
                                    <hr>
                                </div>
                                <div class="col-md-3 hotel_grid_room">
                                    <h5>Room Supply</h5>
                                    @if(count($hotel->room)>0)
                                        @foreach($hotel->room as $room)
                                            @if(($room['availability'] == 1) && ($room['qty'] > 1) )
                                                <div class="hotel_grid_roombox" data-toggle="tooltip"
                                                     title="剩餘房數: {{$room['qty']}}">
                                                    {{$room_type_list[$room['room_type_id']]}}
                                                    <span style="float: right">$ {{$room['price']}}/晚</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        此酒店暫沒有任何房間供應。
                                    @endif

                                    <div class="hotel_grid_btn">
                                        <a href="{{url('/')}}/hotel/{{$hotel->id}}">
                                            <div>查看詳情</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
                <div class="text-center hotel_page">
                    {{ $hotels->appends(request()->except('page'))->links() }} &nbsp;

                </div>
            @else
                <div class="no_result">
                    <div id="no_result_close">
                        {{--<i class="fas fa-times-circle"></i>--}}
                    </div>
                    <i class="fab fa-searchengin"></i>
                    找不到任何結果。請再嘗試。<br>
                    <span>No result found. Please try again.</span>
                </div>
            @endif


        </div>
    </div>

    <div class='scrolltop'>
        <div class='scroll icon button button-3d button-primary'><i class="fa fa-4x fa-angle-up"></i></div>
    </div>
@endsection


@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    {!! Html::script('js/main.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
        $('[data-toggle="tooltip"]').tooltip();
    </script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.js"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        var slider = document.getElementById('slider');
        noUiSlider.create(slider, {
            start: [1000, 4000],
            step: 100,
            connect: true,
            range: {
                'min': 200,
                'max': 5000
            }
        });
        //$('#price_lower').val(1000);
        //$('#price_upper').val(4000);

        slider.noUiSlider.on('change.one', function (values) {
            $('#price_lower').val(values[0]);
            $('#price_upper').val(values[1]);
        });
        $("#price_lower").change(function () {
            slider.noUiSlider.set([$(this).val(), null]);
        });
        $("#price_upper").change(function () {
            slider.noUiSlider.set([null, $(this).val()]);
        });

    </script>

    <script>
        $("#cate").val({{Input::get('category')}});
        $("#star").val({{Input::get('star')}});
        $("#room_type").val({{Input::get('room_type')}});
        $("#people_limit").val({{Input::get('people_limit')}});
    </script>
    
    <script>
        $(function() {
          $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            minDate: new Date(),
              defaultDate: '',
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          });
        });

        setTimeout(function(){ $('#daterange').val(''); }, 1);
    </script>

@endsection