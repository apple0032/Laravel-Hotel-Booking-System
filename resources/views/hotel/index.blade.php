@extends('main')

@section('title', '| All Hotels')

@section('stylesheets')

@endsection

@section('content')
    <style>
        .search_box {
            margin-bottom: 20px;
        }

        .submit {
            background-color: #2d6098;
            border: 0px;
            color: white;
            padding: 6px;
            font-size: 17px;
            border-radius: 3px;
            min-width: 80px;
            text-align: center;
        }

        .form_height {
            margin-top: 10px;
        }

        #submit_search{
            cursor: pointer;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row">
        <div class="col-md-9">
            <h1>All Hotels</h1>
        </div>

        <div class="col-md-3" style="padding-top: 15px">
            <a href="{{ route('hotel.create') }}" class="button button-3d button-primary button-rounded three_d_btn">Create
                New Hotel</a>
        </div>

    </div> <!-- end of .row -->

    <div class="row page_row hotel_index_table">
        <div class="col-md-12">

            <div class="search_box">
                <div class="row">

                    <div class="col-md-10 form_height">
                        <input class="form-control" maxlength="200" name="name" type="text" id="search_hotelname"
                               value="{{$name}}">
                    </div>
                    <div class="col-md-1 form_height">
                        <div class="submit" id="submit_search">SEARCH</div>
                    </div>
                    <div class="col-md-1 form_height" style="text-align: center;">
                        <input onclick="location.href='hotel'" type="reset" value="RESET"
                               class="submit"/>
                    </div>

                </div>
            </div>

            <div id="load_data">
                <b><i class="fas fa-search"></i> &nbsp; Total {{$hotels->count()}} Hotels in this page.</b>
                <table class="table">
                    <thead>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Star</th>
                    <th>Booking Status</th>
                    <th style="text-align: right">Actions</th>
                    <th></th>
                    </thead>

                    <tbody>

                    @foreach ($hotels as $key => $hotel)

                        <tr>
                            <th class="grid_order">{{ $key+1 }}</th>
                            <th>{{ $hotel->id }}</th>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->star }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="{{ $book_percent[$key] }}"
                                         aria-valuemin="0" aria-valuemax="100" style="width:{{ $book_percent[$key] }}%">
                                        {{ $book_percent[$key] }}% Booking
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right" class="hotel_index_action">
                                <a href="{{ route('hotel.show', $hotel->id) }}" class="btn btn-default btn-sm"
                                   data-toggle="tooltip" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('hotel.edit', $hotel->id) }}" class="btn btn-default btn-sm"
                                   data-toggle="tooltip" title="Edit Hotel Information">
                                    <i class="fas fa-pen-nib"></i>
                                </a>

                                <a href="{{ route('hotel.room', $hotel->id) }}" class="btn btn-default btn-sm"
                                   data-toggle="tooltip" title="Manage Room" style="margin-right: 20px;">
                                    <i class="fas fa-bed"></i>
                                </a>

                                <a href="hotel/{{ $hotel->id }}/delete" class="btn btn-default btn-sm"
                                   data-toggle="tooltip"
                                   title="Soft Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

                <div class="text-center">
                    {!! $hotels->links(); !!}
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#search_hotelname").keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                SearchByName();
            }
        });

        $("#submit_search").click(function () {
            SearchByName();
        });

        function SearchByName() {
            var name = $('#search_hotelname').val();
            name = name.replace(/ /g, "|") ;

            $('#load_data').load('hotel?name=' + name + ' #load_data', function () {

            });
        }

    </script>

@endsection