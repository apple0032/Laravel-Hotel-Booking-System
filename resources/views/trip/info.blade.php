@extends('index')

@section('title', '| Trip')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/trip.css') }}">
    <style>
        /* latin-ext */
        @font-face {
            font-family: 'Raleway';
            font-style: normal;
            font-weight: 400;
            src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyCMIT5lu.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Raleway';
            font-style: normal;
            font-weight: 400;
            src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyC0ITw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Dosis';
            font-style: normal;
            font-weight: 400;
            src: local('Dosis Regular'), local('Dosis-Regular'), url(https://fonts.gstatic.com/s/dosis/v8/HhyaU5sn9vOmLzlmC_W6EQ.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Dosis';
            font-style: normal;
            font-weight: 400;
            src: local('Dosis Regular'), local('Dosis-Regular'), url(https://fonts.gstatic.com/s/dosis/v8/HhyaU5sn9vOmLzloC_U.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .navbar{
            margin-bottom: 0px;
        }

        body {
            background-image: url('') !important;
            background: #f2f2f2;
        }
        
    </style>

    <div class="trip_details row">

        <div class="flight_section col-md-6">
            <div class="flight_title">
                <i class="fas fa-ticket-alt"></i> Electronic flight ticket
                <a href="{{URL::to('/')}}/flight-summary"><i class="fas fa-link"></i></a>
            </div>

            @foreach($flight as $ft)
                <div class="ticket">
                    <div class="row ticket_header">
                        <div class="col-md-8 ticket_big">
                            <img src="http://pics.avs.io/250/40/{{$ft->airline_code}}.png">
                        </div>
                        <div class="col-md-4 ticket_small">
                            <img src="http://pics.avs.io/250/40/{{$ft->airline_code}}.png">
                        </div>
                    </div>

                    <div class="row ticket_body">
                        <div class="col-md-8 ticket_big">
                            <div class="pass_name">
                                {{$ft->people_name}}
                            </div>
                            <div class="row ticket_details">
                                <div class="col-md-3">
                                    <span class="ticket_title">Flight</span>
                                    {{$ft->flight_code}}
                                </div>
                                <div class="col-md-3">
                                   <span class="ticket_title">BOARDING</span>
                                    {{$ft->flight_start}}
                                </div>
                                <div class="col-md-3">
                                    <span class="ticket_title">GATE</span>
                                    2
                                </div>
                                <div class="col-md-3">
                                    <span class="ticket_title">SEAT</span>
                                    {{$ft->seat}}
                                </div>
                            </div>
                            <div class="row ticket_details">
                                <div class="col-md-3">
                                    <span class="ticket_title">ROUTE</span>
                                    {{$ft->country_code.' > '.$ft->arr_country_code}}
                                </div>
                                <div class="col-md-3">
                                    <span class="ticket_title">DATE</span>
                                    {{substr($ft->dep_date, 0, 10)}}
                                </div>
                                <div class="col-md-3">
                                    <span class="ticket_title">DEPARTURE</span>
                                    {{$ft->flight_end}}
                                </div>
                                <div class="col-md-3">
                                    <span class="ticket_title">TERMINAL</span>
                                    1
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 ticket_small">
                            <div class="pass_name">
                                {{$ft->people_name}}
                            </div>
                            <div class="row ticket_details">
                                <div class="col-md-6">
                                    <span class="ticket_title">Flight</span>
                                    {{$ft->flight_code}}
                                </div>
                                <div class="col-md-6">
                                    <span class="ticket_title">BOARDING</span>
                                    {{$ft->flight_start}}
                                </div>
                                <div class="col-md-6">
                                    <span class="ticket_title">SEAT</span>
                                    {{$ft->seat}}&nbsp;
                                </div>

                                <div class="col-md-6">
                                    <span class="ticket_title">ROUTE</span>
                                    {{$ft->country_code.' > '.$ft->arr_country_code}}
                                </div>
                                <div class="col-md-6">
                                    <span class="ticket_title">DATE</span>
                                    {{substr($ft->dep_date, 0, 10)}}
                                </div>
                                <div class="col-md-6">
                                    <span class="ticket_title">DEPARTURE</span>
                                    {{$ft->flight_end}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ticket_footer">
                        <div class="col-md-8 ticket_big">
                            <img src="http://vic.hk:8080/BarcodeGenerator/?barcode={{$ft->related_flight_id}}&height=35&fontsize=12&fontname=Arial&showtext=false&bold=true">
                            <span class="qr_code">
                                <img src="http://chart.apis.google.com/chart?cht=qr&chl={{$ft->related_flight_id}}&chs=50x50&chld=H|0">
                            </span>
                        </div>
                        <div class="col-md-4 ticket_small">
                            <span class="qr_code">
                                <img src="http://chart.apis.google.com/chart?cht=qr&chl={{$ft->related_flight_id}}&chs=50x50&chld=H|0">
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        
        <div class="hotel_section col-md-6">
        @if($booking != null)
                <div class="load_hotel">
                    <div class="flight_title">
                        <i class="fas fa-hotel"></i> Hotel booking
                        <a href="{{URL::to('/')}}/book/booklist"><i class="fas fa-link"></i></a>
                    </div>

                    <div class="hotel_content">
                        <div class="row">
                            <div class="col-md-12 hotel_content_image">
                                @if( ($booking->image == 'null.jpg') && ($booking->default_image != '') &&  ($booking->default_image != null) )
                                    <img src="https://photos.hotellook.k8s.avs.io/image_v2/limit/h{{$booking->default_image}}_0/640/480.jpg">
                                @elseif( ($booking->image != 'null.jpg') && ($booking->image != '') && ($booking->image != null) )
                                    <img src="{{URL::to('/')}}/images/upload/{{$booking->image}}">
                                @else
                                    <img src="{{URL::to('/')}}/images/no_image.jpg">
                                @endif
                            </div>
                            <div class="col-md-12 hotel_details">
                                <div class="row">
                                    <div class="col-md-4 hotel_content_title">
                                        Hotel Name
                                    </div>
                                    <div class="col-md-8">
                                        {{$booking->name}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 hotel_content_title">
                                        Check in time
                                    </div>
                                    <div class="col-md-8">
                                        {{substr($booking->in_date, 0, 10)}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 hotel_content_title">
                                        Check out time
                                    </div>
                                    <div class="col-md-8">
                                        {{substr($booking->out_date, 0, 10)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @else
            <div class="hotel_section2 col-md-12">
                <div class="row no_hotel_block">
                    <div class="col-md-12 no_hotel_button" onclick="window.location.href='#'">
                        <i class="fas fa-exclamation-circle"></i> &nbsp;&nbsp; No hotel booking linkage right now. Do it now?
                    </div>
                    <div class="col-md-12 no_hotel_select" onclick="window.location.href='#'">
                        <select class="form-control" id="sel1">
                            @if($bk != null)
                                @foreach($bk as $b)
                                    <option value="{{$b['id']}}">{{$b['id'].' - '.$b['hotel'].' - '.$b['in_date'].' to '.$b['out_date']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <button type="button" class="btn btn-primary link_submit">Confirm</button>
                    </div>
                </div>
            </div>
        @endif
        
        @if($booking != null)
        <div class="col-md-12 dismatch_btn">
            <i class="fas fa-ban"></i> Dismatch this booking
        </div>
        @endif
        
        </div>
    </div>

@endsection

@section('scripts')


@endsection