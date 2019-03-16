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
            transition: 0.2s all;
            cursor: pointer;
        }

        .submit:hover{
            background-color: #268898;
        }

        .form_height {
            margin-top: 10px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row">
        <div class="col-md-9">
            <h2>All Users</h2>
        </div>

    </div> <!-- end of .row -->

    <div class="row page_row hotel_index_table">
        <div class="col-md-12">

            <div class="search_box">
                <div class="row">

                    <div class="col-md-10 form_height">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-users"></i></span>
                            <input class="form-control" maxlength="200" name="name" type="text" id="search_hotelname"
                                   value="{{$name}}">
                        </div>
                    </div>
                    <div class="col-md-1 form_height">
                        <div class="submit" id="submit_search">SEARCH</div>
                    </div>
                    <div class="col-md-1 form_height" style="text-align: center;">
                        <div class="submit" id="submit_reset">RESET</div>
                    </div>

                </div>
            </div>

            <div id="load_data">
                <b><i class="fas fa-search"></i> &nbsp; Total {{$users->count()}} users in Hotelsdb.</b>
                <table class="table">
                    <thead>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Create</th>
                    </thead>

                    <tbody>

                    @foreach ($users as $key => $user)

                        <tr>
                            <th class="grid_order">{{ $key+1 }}</th>
                            <th>{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

                <div class="text-center">
                    {!! $users->links(); !!}
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
            name = name.replace(/ /g, "|");

            $('#load_data').load('{{ route('admin.user') }}?name=' + name + ' #load_data', function () {

            });
        }

        $("#submit_reset").click(function () {
            $('#load_data').load('{{ route('admin.user') }} #load_data', function () {

            });
        });


    </script>

@endsection