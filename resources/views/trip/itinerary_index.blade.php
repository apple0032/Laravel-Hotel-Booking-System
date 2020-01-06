@extends('main')

@section('title', '| Itinerary')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <style>
        body {
            font-family: 'Quicksand', sans-serif !important;
        }

        .book_container {
            margin-bottom: 40px;
        }

        .table_header{
            background-color: #228c98;
            color: white;
        }

        .action_group {
            text-align: center;
        }

        .action_group i{
            font-size: 18px;
            color: #2d6098;
            cursor: pointer;
        }

        .flag{
            text-align: center;
            background-color: #070f1012;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="container book_container">
                <h2><i class="fas fa-umbrella-beach"></i> Itineraries</h2><br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                    <input class="form-control" id="myInput" type="text" placeholder="Search">
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="table_header">
                            <th>Country</th>
                            <th>City</th>
                            <th>Trip Start</th>
                            <th>Trip End</th>
                            <th>Total Day</th>
                            <th>Create Time</th>
                            <th>Update Time</th>
                            <th>View & Edit</th>
                            <th>Copy</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">

                        @foreach($itineraries as $key => $itinerary)
                            <tr class="book_row book_{{$itinerary['id']}}" data-sid="{{$itinerary['id']}}">
                                <td class="flag">
                                    @if($city[$key]['flag'] != null)
                                    <img src="https://countryflags.io/{{$city[$key]['flag']}}/flat/32.png">
                                    @endif
                                </td>
                                <td>{{ucfirst($city[$key]['city'])}}</td>
                                <td>{{$city[$key]['start']}}</td>
                                <td>{{$city[$key]['end']}}</td>
                                <td>{{$city[$key]['total']}} Days</td>
                                <td>{{$itinerary['created_at']}}</td>
                                <td>{{$itinerary['updated_at']}}</td>
                                <td class="action_group"><a href="../{{$itinerary['id']}}"><i class="fas fa-eye"></i></a></td>
                                <td class="action_group"><i class="fas fa-copy"  onclick="copyItinerary({{$itinerary['id']}})"></i></td>
                                <td class="action_group"><i class="fas fa-trash" onclick="deleteItinerary({{$itinerary['id']}})"></i></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <i class="fas fa-calendar-minus"></i> You have total <b>{{count($itineraries)}}</b> of itineraries.
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

        function deleteItinerary(id) {
            if(confirm('Sure to delete this itinerary?')){
                window.location.href = "../../delete-itinerary/"+id;
            }
        }

        function copyItinerary(id) {
            if(confirm('Sure to copy this itinerary?')){
                window.location.href = "../../copy-itinerary/"+id;
            }
        }
    </script>
@endsection
