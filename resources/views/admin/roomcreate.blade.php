@extends('main')

@section('title', '| Create New Room')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
//			menubar: false
        });
    </script>

@endsection

@section('content')
    <div class="row page_row">
        <div class="col-md-12">
            <h2>Create New Room - {{$hotel->name}}</h2>
            <hr>

            <div class="row">
                <div class="col-md-7">
                    {{ Form::open(['route' => ['hotel.roomstore', $hotel->id], 'method' => 'POST']) }}

                    {{ Form::label('room_type_id', 'Room Type:') }}
                    <select class="form-control" name="room_type_id">
                        @if($type_lefts != null)
                            <option value="" disabled selected>-- Select --</option>
                            @foreach($type_lefts as $type_left)
                                <option value='{{ $type_left['id'] }}'>{{ $type_left['type'] }}</option>
                            @endforeach
                        @else
                            <option value="" disabled selected>No available room can be created by this hotel.</option>
                        @endif
                    </select>

                    {{ Form::label('ppl_limit', 'People Limit:') }}
                    {{ Form::text('ppl_limit', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '3')) }}

                    {{ Form::label('price', 'Price:') }}
                    {{ Form::text('price', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '6')) }}

                    {{ Form::label('qty', 'Supply:') }}
                    {{ Form::text('qty', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '6')) }}

                    {{ Form::label('availability', 'Availability:') }}

                    <div class="room_avail_box">
                        Yes
                        {{ Form::radio('availability', '1' , true) }}
                        No
                        {{ Form::radio('availability', '0' , false) }}
                    </div>

                    <br>
                    {{ Form::label('promo', 'Promo:') }}
                    <br>
                    <div class="room_avail_box">
                        Yes
                        {{ Form::radio('promo', '1' , false) }}
                        No
                        {{ Form::radio('promo', '0' , true) }}
                    </div>
                </div>

                <div class="col-md-5 well">
                    @foreach($room_facility_list as $key => $room_facility)
                        <div class="row">
                            <div class="col-md-2">
                                <i class="fas {{$temp_fontawesome[$key]}}"></i>
                            </div>
                            <div class="col-md-4">
                                {{$room_facility_label[$key]}}
                            </div>

                            <div class="col-md-6">
                                <p class="btn-switch">
                                    <input type="radio" id="{{$room_facility}}_yes" name="{{$room_facility}}" value="1"
                                           class="btn-switch__radio btn-switch__radio_yes"/>
                                    <input type="radio" id="{{$room_facility}}_no" name="{{$room_facility}}" value="0"
                                           checked
                                           class="btn-switch__radio btn-switch__radio_no"/>

                                    <label for="{{$room_facility}}_yes" class="btn-switch__label btn-switch__label_yes">
                                        <span class="btn-switch__txt">Yes</span>
                                    </label>

                                    <label for="{{$room_facility}}_no" class="btn-switch__label btn-switch__label_no">
                                        <span class="btn-switch__txt">No</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    {{ Form::submit('Create Room', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
                </div>
                <div class="col-md-6">
                    {!! Html::linkRoute('hotel.room', 'Cancel',$hotel->id, array('class' => 'btn btn-danger btn-lg btn-block' , 'style' => 'margin-top: 20px;')) !!}
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection


@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>

@endsection
