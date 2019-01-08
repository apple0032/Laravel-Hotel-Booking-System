@extends('main')

@section('title', '| Hotel Room')

@section('content')

    <style>
        .room_header i{
            font-size: 21px !important;
        }
    </style>

    <div class="row page_row hotel_index_table">
        <div class="col-md-12">
            <div class="row room_header">
                <div class="col-md-8">
                    <h2>{{$hotel['name']}}</h2>
                </div>
                <div class="col-md-2" style="margin-top: 5px">
                    <a href="{{ route('admin.hotel',['name' => $hotel->id]) }}"
                       class="button button-3d button-caution button-rounded three_d_btn">
                        <i class="fas fa-backward"></i>
                    </a>
                </div>
                <div class="col-md-2" style="margin-top: 5px">
                    <a href="{{ route('hotel.roomcreate',['id' => $hotel->id]) }}"
                       class="button button-3d button-primary button-rounded three_d_btn">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>
            <hr>

            @foreach($hotel->room as $room)

                <div class="hotel_room_box">
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
                        <div class="col-md-7 hotel_room_detail">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="title"> Type:</div>
                                    People Limit:<br>
                                    Price:<br>
                                    Supply:<br>
                                    Availability:<br>
                                    Promo:<br>
                                </div>
                                <div class="col-md-3">
                                    <div class="title">
                                        {{$type_list[$room->room_type_id]}}<br>
                                    </div>
                                    {{$room->ppl_limit}}人<br>
                                    $ {{$room->price}}<br>
                                    {{$room->qty}}<br>
                                    {{$room->availability}}<br>
                                    {{$room->promo}}<br>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($room_facility_list as $key =>$fac)
                                       @if($room->facility[$fac] == 1)
                                            <i class="fas {{$temp_fontawesome[$key]}}" data-toggle="tooltip" title="{{$room_facility_label[$key]}}"></i>
                                       @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 hotel_room_action">
                            <a href="room/{{$room->id}}/edit" class="btn btn-default btn-sm" data-toggle="tooltip"
                               title="Edit">
                                <i class="fas fa-pen-nib"></i>
                            </a>

                            <a href="room/{{$room->id}}/delete" class="btn btn-default btn-sm" data-toggle="tooltip"
                               title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@stop