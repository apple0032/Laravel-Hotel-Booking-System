@extends('main')

@section('title', '| Create New Hotel')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'fontsizeselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            height: 470
//			menubar: false
        });
    </script>


    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>

@endsection

@section('content')

    <div class="row page_row">
        <div class="col-md-8">
            <h1>Create New Hotel</h1>
            <hr>
            {!! Form::open(array('route' => 'hotel.store', 'data-parsley-validate' => '', 'files' => true)) !!}
            {{ Form::label('title', 'Name:') }}
            {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

            {{ Form::label('phone', 'Phone:') }}
            {{ Form::text('phone', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '15')) }}

            {{ Form::label('star', 'Star:') }}
            <select class="form-control" name="star">
                @foreach($stars as $star)
                    <option value='{{ $star }}'>{{ $star }}</option>
                @endforeach
            </select>


            {{ Form::label('category_id', 'Category:') }}
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option value='{{ $category->id }}'>{{ $category->name }}</option>
                @endforeach

            </select>


            {{ Form::label('tags', 'Tags:') }}
            <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                @foreach($tags as $tag)
                    <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                @endforeach

            </select>
            <br><br>

            {{ Form::label('featured_img', 'Upload a Featured Image') }}
            {{ Form::file('featured_img') }}

            <br>
            
            {{ Form::label('handling_price', 'Handling price:') }}
            {{ Form::text('handling_price', null, ["class" => 'form-control input-lg']) }}

            <b>Point a address - </b>
            <div id="map" style="width: 100%; height: 515px; background: grey"></div>
            <div class="row">
                <div class="col-md-6">
                    <input class="form-control input-lg" id="coordi_x" readonly name="coordi_x" type="text"
                           value="22.297571">
                </div>
                <div class="col-md-6">
                    <input class="form-control input-lg" id="coordi_y" readonly name="coordi_y" type="text"
                           value="114.172194">
                </div>
            </div>

            <br>

        </div>
        <div class="col-md-4">
            <div class="well">
                <div class="hotel_create_btn">
                    <a href="{{ route('hotel.index') }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
                </div>
                <div class="hotel_create_btn">
                    {{ Form::submit('Create Hotel', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
                </div>
            </div>

            <div class="well" style="padding-left: 10px; padding-right: 0px">
                <div class="hotel_fac_band">Hotel Facility</div>

                @foreach($hotel_facility_list as $key => $hotel_facility)
                    <div class="row hotel_fac_row" style="margin-bottom:5px;">
                        <div class="col-md-1">
                            <i class="fas {{$temp_fontawesome[$key]}}"></i>
                        </div>
                        <div class="col-md-6">
                            {{ Form::label($hotel_facility, $hotel_facility_label[$key]) }}
                            <br>
                        </div>
                        <div class="col-md-5 nopadding">

                            <p class="btn-switch">
                                <input type="radio" id="{{$hotel_facility}}_yes" name="{{$hotel_facility}}" value="1"
                                       class="btn-switch__radio btn-switch__radio_yes"/>
                                <input type="radio" id="{{$hotel_facility}}_no" name="{{$hotel_facility}}" value="0"
                                       checked class="btn-switch__radio btn-switch__radio_no"/>

                                <label for="{{$hotel_facility}}_yes" class="btn-switch__label btn-switch__label_yes">
                                    <span class="btn-switch__txt">Yes</span>
                                </label>

                                <label for="{{$hotel_facility}}_no" class="btn-switch__label btn-switch__label_no">
                                    <span class="btn-switch__txt">No</span>
                                </label>
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {{ Form::label('body', "Hotel Body:") }}
                {{ Form::textarea('body', null, array('class' => 'form-control')) }}
                <div class="full_screen_btn">Ctrl+Shift+F to Full Screen</div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection


@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>
    <script>

        /**
         * Adds a  draggable marker to the map..
         *
         * @param {H.Map} map                      A HERE Map instance within the
         *                                         application
         * @param {H.mapevents.Behavior} behavior  Behavior implements
         *                                         default interactions for pan/zoom
         */
        function addDraggableMarker(map, behavior) {

            var marker = new H.map.Marker({lat: 22.297571, lng: 114.172194});
            // Ensure that the marker can receive drag events
            marker.draggable = true;
            map.addObject(marker);

            // disable the default draggability of the underlying map
            // when starting to drag a marker object:
            map.addEventListener('dragstart', function (ev) {
                var target = ev.target;
                if (target instanceof H.map.Marker) {
                    behavior.disable();
                }
            }, false);


            // re-enable the default draggability of the underlying map
            // when dragging has completed
            map.addEventListener('dragend', function (ev) {
                var target = ev.target;
                //console.log(marker.getPosition().lat);
                // console.log(marker.getPosition().lng);
                $('#coordi_x').val(marker.getPosition().lat);
                $('#coordi_y').val(marker.getPosition().lng);


                if (target instanceof mapsjs.map.Marker) {
                    behavior.enable();
                }
            }, false);

            // Listen to the drag event and move the position of the marker
            // as necessary
            map.addEventListener('drag', function (ev) {
                var target = ev.target,
                    pointer = ev.currentPointer;
                if (target instanceof mapsjs.map.Marker) {
                    target.setPosition(map.screenToGeo(pointer.viewportX, pointer.viewportY));
                }
            }, false);
        }

        /**
         * Boilerplate map initialization code starts below:
         */

//Step 1: initialize communication with the platform
        var platform = new H.service.Platform({
            app_id: 'DemoAppId01082013GAL',
            app_code: 'AJKnXv84fjrb0KIHawS0Tg',
            useCIT: true,
            useHTTPS: true
        });
        var defaultLayers = platform.createDefaultLayers();

        //Step 2: initialize a map - this map is centered over Boston
        var map = new H.Map(document.getElementById('map'),
            defaultLayers.normal.map, {
                center: {lat: 22.297571, lng: 114.172194},
                zoom: 16
            });

        //Step 3: make the map interactive
        // MapEvents enables the event system
        // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
        var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

        // Step 4: Create the default UI:
        var ui = H.ui.UI.createDefault(map, defaultLayers, 'en-US');

        // Add the click event listener.
        addDraggableMarker(map, behavior);

        $('head').append('<link rel="stylesheet" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css" type="text/css" />');

    </script>

@endsection
