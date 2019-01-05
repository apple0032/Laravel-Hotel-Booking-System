@extends('main')

@section('title', '| Booking')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <style>
        body {
            font-family: "Noto Sans TC", sans-serif !important;
        }

        .book_container {
            margin-bottom: 40px;
        }

        .book_row {
            cursor: pointer;
        }

        .book_detail {
            display: none;
        }

        .book_detail_col {
            border-right: 1px solid #2d6098;
        }

        .hotel_name {
            font-weight: bold;
            font-size: 17px;
        }

        .book_detail_room {
            font-size: 16px;
        }

        .book_detail_room div {
            margin-bottom: 10px;
        }

        .book_detail_guest {
            font-size: 16px;
        }

        .guest_email {
            text-overflow: ellipsis;
            max-width: 150px;
            overflow: hidden !important;
            white-space: nowrap;
        }

        .table_header{
            background-color: #2d6098;
            color: white;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2>您的酒店預約</h2><br>

                <input class="form-control" id="myInput" type="text" placeholder="搜尋">

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>預訂ID</th>
                            <th>酒店</th>
                            <th>酒店房間</th>
                            <th>人數</th>
                            <th>入住日期</th>
                            <th>退房日期</th>
                            <th>預約時間</th>
                            <th>總價錢</th>
                            <th>狀態</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->id}}" data-sid="{{$bk->id}}">
                                <td>{{$bk->id}}</td>
                                <td>{{$bk->hotel['name']}}</td>
                                <td>{{$room_type[$key]}}</td>
                                <td>{{$bk->people}} 人</td>
                                <td>{{substr($bk->in_date, 0,10)}}</td>
                                <td>{{substr($bk->out_date, 0,10)}}</td>
                                <td>{{$bk->book_date}}</td>
                                <td>$ {{$bk->total_price}}</td>
                                <td>@if($bk->status == 1) 正常 @endif</td>
                            </tr>
                            <tr class="book_detail bk_detail{{$bk->id}} animated flipInX faster">
                                <td colspan="9">
                                    <div class="row well" style="margin: 0px">
                                        <div class="col-md-4 col-sm-12 book_detail_col">

                                            @if($bk['hotel']['image'] != 'null.jpg')
                                                <img src="{{url('/')}}/images/upload/{{$bk['hotel']['image']}}"
                                                     class="img-responsive">
                                            @else
                                                <img src="http://photo.hotellook.com/image_v2/limit/h{{$bk['hotel']['default_image']}}_0/640/480.jpg"
                                                     class="img-responsive">
                                            @endif
                                            <div class="hotel_name">
                                                <a href="{{url('/')}}/hotel/{{$bk['hotel']['id']}}"> {{$bk->hotel['name']}}
                                                    <br> </a>
                                                <?php for ($x = 0; $x < $bk['hotel']['star']; $x++) { ?>
                                                <i class="fas fa-star" style="color: #f6ab3f"></i>
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <div class="col-md-4 col-sm-12 book_detail_col">
                                            <div class="row book_detail_room">
                                                <div class="col-md-6">
                                                    房間種類
                                                </div>
                                                <div class="col-md-6">
                                                    {{$room_type[$key]}}
                                                </div>
                                                <div class="col-md-6">
                                                    每晚收費
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['single_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    預訂手續費
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['handling_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    入住日數
                                                </div>
                                                <div class="col-md-6">
                                                    <?php
                                                    $date1 = date_create($bk->in_date);
                                                    $date2 = date_create($bk->out_date);
                                                    $diff = date_diff($date1, $date2);
                                                    echo $diff->format("%a 日");
                                                    ?>
                                                </div>
                                                <div class="col-md-6">
                                                    總價錢
                                                </div>
                                                <div class="col-md-6">
                                                    $ {{$bk->payment['total_price']}}
                                                </div>
                                                <div class="col-md-6">
                                                    付款方式
                                                </div>
                                                <div class="col-md-6">
                                                    @if($bk->payment['payment_method_id'] == 5)
                                                        入住到付
                                                    @else
                                                        {{$pay_method[$key]}}
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    付款狀態
                                                </div>
                                                <div class="col-md-6">
                                                    @if($bk->payment['status'] == 1)
                                                        <span style="color:#53c667">成功</span>
                                                    @else
                                                        <span style="color:red">未完成</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="row book_detail_guest">
                                                <div class="col-md-1">
                                                    &nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                    名稱
                                                </div>
                                                <div class="col-md-3">
                                                    電話
                                                </div>
                                                <div class="col-md-5">
                                                    電郵
                                                </div>
                                            </div>
                                            @foreach($bk->guest as $guest)
                                                <div class="row book_detail_guest">
                                                    <div class="col-md-1">
                                                        <i class="fas fa-male"></i>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$guest->name}}
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if($guest->phone != '0')
                                                            {{$guest->phone}}
                                                        @else
                                                            /
                                                        @endif
                                                    </div>
                                                    <div class="col-md-5 guest_email">
                                                        @if($guest->email != '')
                                                            {{$guest->email}}
                                                        @else
                                                            /
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        {{--<tr>--}}
                        {{--<td colspan="9">Sum: $180</td>--}}
                        {{--</tr>--}}

                        </tbody>
                    </table>
                </div>

                <i class="fas fa-hotel"></i> 您共有 <b>{{$booking->count()}}</b> 項酒店預約
            </div>


        </div>
    </div>
    <script>

        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr:not('.book_detail')").filter(function () {
                $('.book_detail').fadeOut();
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $(".dropdown").click(function () {
            $(".dropdown").addClass('open');
        });

        $('.book_row').each(function () {
            $(this).on("click", function () {
                var sid = $(this).data('sid');

                if ($('.bk_detail' + sid).hasClass("act") == false) {

                    $('.bk_detail' + sid).fadeIn();
                    $('.bk_detail' + sid).addClass('act');

                    $('.book_detail:not(.bk_detail' + sid + ')').hide();
                    $('.book_detail:not(.bk_detail' + sid + ')').removeClass('act');
                } else {
                    $('.bk_detail' + sid).fadeOut();
                    $('.bk_detail' + sid).removeClass('act');
                }
            });
        });

    </script>
@endsection
