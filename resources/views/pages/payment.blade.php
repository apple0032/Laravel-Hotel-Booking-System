@extends('main')

@section('title', '| Payment')

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
            /*cursor: pointer;*/
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
            background-color: #228c98;
            color: white;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2><i class="fas fa-money-check-alt"></i> Payment Record</h2><br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                    <input class="form-control" id="myInput" type="text" placeholder="Search">
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>Hotel</th>
                            <th>Room Class</th>
                            <th>People</th>
                            <th>Days</th>
                            <th>Price/day</th>
                            <th>Handling Fee</th>
                            <th>Total Price</th>
                            <th>Method</th>
                            <th>Card Number</th>
                            <th>Status</th>
                            <th>Create Datetime</th>

                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($booking as $key => $bk)
                            <tr class="book_row book_{{$bk->id}}" data-sid="{{$bk->id}}">
                                <td>{{$bk->hotel['name']}}</td>
                                <td>{{$room_type[$key]}}</td>
                                <td>{{$bk->people}} 人</td>
                                <td>
                                    <?php
                                    $date1 = date_create($bk->in_date);
                                    $date2 = date_create($bk->out_date);
                                    $diff = date_diff($date1, $date2);
                                    echo $diff->format("%a 日");
                                    ?>
                                </td>
                                <td>$ {{$bk->payment['single_price']}}</td>
                                <td>$ {{$bk->payment['handling_price']}}</td>
                                <td>$ {{$bk->total_price}}</td>
                                <td>
                                    @if($bk->payment['payment_method_id'] == 5)
                                        入住到付
                                    @else
                                        {{$pay_method[$key]}}
                                    @endif
                                </td>
                                <td>
                                    @if($bk->payment['card_number'] == '')
                                        /
                                    @else
                                        @php
                                        $card_no = substr($bk->payment['card_number'], 0, 4);
                                        print_r($card_no.'****');
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if($bk->payment['status'] == 1)
                                        <span style="color:#53c667">成功</span>
                                    @else
                                        <span style="color:red">未完成</span>
                                    @endif
                                </td>
                                <td>{{$bk->book_date}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <i class="far fa-credit-card"></i> You have total <b>{{$booking->count()}}</b> of payment record
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

    </script>
@endsection
