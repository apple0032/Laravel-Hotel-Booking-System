@extends('main')

@section('title', '| My Flight')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <style>
        #myTable{
            font-weight: bold;
        }

        @media (min-width: 1200px) {
            .container {
                width: 1500px;
            }
        }

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

        .book_detail_room {
            font-size: 16px;
        }

        .book_detail_room div {
            margin-bottom: 10px;
        }

        .table_header{
            background-color: rgb(166, 86, 86);
            color: white;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2><i class="fas fa-plane-departure"></i> 您的航班預約</h2><br>

                <input class="form-control" id="myInput" type="text" placeholder="搜尋">

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>國家/城市</th>
                            <th>出發</th>
                            <th>到達</th>
                            <th>日期</th>
                            <th>航空公司</th>
                            <th>航班</th>
                            <th>起飛</th>
                            <th>落機</th>
                            <th>需時</th>
                            <th>價錢</th>
                            <th>燃油</th>
                            <th>機位</th>
                            <th>選位</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->id}}" data-sid="{{$bk->id}}" style="">
                                <td><img src="https://countryflags.io/{{$bk->country_code}}/flat/32.png">　{{$bk->country}}</td>
                                <td>{{$bk->dep_airport}}</td>
                                <td>{{$bk->arr_airport}}</td>
                                <td>{{substr($bk->dep_date,0,10)}}</td>
                                <td><img src="http://pics.avs.io/250/40/{{$bk['airline_code']}}.png" style="zoom: 0.6">{{$bk->airline_name}}</td>
                                <td>{{$bk->flight_code}}</td>
                                <td>{{$bk->flight_start}}</td>
                                <td>{{$bk->flight_end}}</td>
                                <td>{{$bk->duration}}</td>
                                <td>$ {{$bk->price}}</td>
                                <td>$ {{$bk->tax}}</td>
                                <td>{{$bk->class}}</td>
                                <td>1</td>
                            </tr>
                            <tr class="book_detail bk_detail{{$bk->id}} animated bounceInDown faster">
                                <td colspan="13">
                                    <div class="row well" style="margin: 0px">
                                        <div class="col-md-4 col-sm-12 book_detail_col">
                                            payment
                                        </div>
                                        <div class="col-md-4 col-sm-12 book_detail_col" style="padding-left: 30px;">
                                            <div class="row">
                                                seat
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            passenger
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

                <i class="fas fa-bars"></i> 您共有 <b>{{$booking->count()}}</b> 項航班預約記錄
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
