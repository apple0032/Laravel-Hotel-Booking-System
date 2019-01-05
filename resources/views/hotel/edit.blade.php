@extends('main')

@section('title', '| Edit Hotel')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css"/>
    <style>
        .page-heading {
            margin: 20px 0;
            color: #666;
            -webkit-font-smoothing: antialiased;
            font-family: "Segoe UI Light", "Arial", serif;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        #my-dropzone .message {
            font-family: "Segoe UI Light", "Arial", serif;
            font-weight: 600;
            color: #0087F7;
            font-size: 1.5em;
            letter-spacing: 0.05em;
        }

        .dropzone {
            border: 2px dashed #0087F7;
            background: white;
            border-radius: 5px;
            min-height: 300px;
            padding: 90px 0;
            vertical-align: baseline;
        }

        .dz-remove {
            display: none !important;
        }
    </style>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: 'code print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
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
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row page_row">
        {!! Form::model($hotel, ['route' => ['hotel.update', $hotel->id], 'data-parsley-validate' => '', 'files' => true, 'method' => 'PUT']) !!}
        <div class="col-md-8">
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name', null, ["class" => 'form-control input-lg']) }}

            {{ Form::label('phone', 'Phone:') }}
            {{ Form::text('phone', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '15')) }}

            {{ Form::label('star', 'Star:') }}
            <select class="form-control" name="star">
                @foreach($stars as $star)
                    <option value='{{ $star }}' <?php if ($star == $hotel->star) {
                        echo 'selected';
                    }?> >{{ $star }}</option>
                @endforeach
            </select>

            {{ Form::label('category_id', "Category:", ['class' => '']) }}
            {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

            {{ Form::label('tags', 'Tags:' ,['class' => 'form-spacing-top']) }}
            <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                @foreach($tags as $tag)
                    @foreach($hotel_tags as $hotel_tag)
                        @if($tag->id == $hotel_tag['tag_id'])
                            <option value='{{ $tag->id }}' selected>{{ $tag->name }}</option>
                        @endif
                    @endforeach
                @endforeach

                @foreach($tags as $tag)
                    @foreach($hotel_notags as $hotel_notag)
                        @if($tag->id == $hotel_notag)
                            <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                        @endif
                    @endforeach
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
                           value="@if($hotel->coordi_x != null) {{$hotel->coordi_x}} @endif">
                </div>
                <div class="col-md-6">
                    <input class="form-control input-lg" id="coordi_y" readonly name="coordi_y" type="text"
                           value="@if($hotel->coordi_y != null) {{$hotel->coordi_y}} @endif">
                </div>
            </div>

            <br>



        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">

                        <div class="current_img">
                            @if($hotel->image != 'null.jpg')
                                <img src="{{asset('/images/upload/'.$hotel->image)}}"
                                     class="hotel_edit_img img-responsive">
                            @else
                                <img src="{{asset('/images/not-available.png')}}" class="hotel_edit_img img-responsive">
                            @endif
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-4 right_side_title">Created At:</div>
                            <div class="col-md-8">{{ date('M j, Y h:ia', strtotime($hotel->created_at)) }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 right_side_title">Updated At:</div>
                            <div class="col-md-8">{{ date('M j, Y h:ia', strtotime($hotel->updated_at)) }}</div>
                        </div>


                        <hr>
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-sm-6">
                                {!! Html::linkRoute('hotel.show', 'View', array($hotel->id), array('class' => 'btn btn-primary btn-block')) !!}
                            </div>
                            <div class="col-sm-6">
                                {!! Html::linkRoute('hotel.index', 'Cancel', array($hotel->id), array('class' => 'btn btn-danger btn-block')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 hotel_fac_area">
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

                                    @if($hotel_facility_selected->$hotel_facility == 1)
                                        @php $click = 'true'; @endphp
                                    @else
                                        @php $click = 'false' @endphp
                                    @endif

                                    <p class="btn-switch">
                                        <input type="radio" id="{{$hotel_facility}}_yes" name="{{$hotel_facility}}"
                                               value="1"
                                               @if( $click == 'true'){{"checked"}}@endif class="btn-switch__radio btn-switch__radio_yes"/>
                                        <input type="radio" id="{{$hotel_facility}}_no" name="{{$hotel_facility}}"
                                               value="0"
                                               @if( $click != 'true'){{"checked"}}@endif class="btn-switch__radio btn-switch__radio_no"/>

                                        <label for="{{$hotel_facility}}_yes"
                                               class="btn-switch__label btn-switch__label_yes">
                                            <span class="btn-switch__txt">Yes</span>
                                        </label>

                                        <label for="{{$hotel_facility}}_no"
                                               class="btn-switch__label btn-switch__label_no">
                                            <span class="btn-switch__txt">No</span>
                                        </label>
                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {{ Form::label('body', "Hotel Body:", ['class' => 'form-spacing-top']) }}
                {{ Form::textarea('body', null, ['class' => 'form-control']) }}
                <div class="full_screen_btn">Ctrl+Shift+F to Full Screen</div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="row">
            <div class="col-sm-12">
                <h2 class="page-heading">Upload Hotel Images <span id="counter"></span></h2>
                <form method="post" action="{{ url('/images-save') }}"
                      enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                    {{ csrf_field() }}
                    <input type="hidden" name="hotel_id" value="{{$hotel->id}}">
                    <div class="dz-message">
                        <div class="col-xs-12">
                            <div class="message">
                                <p>Drop files here or Click to Upload</p>
                            </div>
                        </div>
                    </div>
                    <div class="fallback">
                        <input type="file" name="file" multiple>
                    </div>
                </form>
            </div>
        </div>

        {{--Dropzone Preview Template--}}
        <div id="preview" style="display: none;">

            <div class="dz-preview dz-file-preview">
                <div class="dz-image"><img data-dz-thumbnail/></div>

                <div class="dz-details">
                    <div class="dz-size"><span data-dz-size></span></div>
                    <div class="dz-filename"><span data-dz-name></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>


                <div class="dz-success-mark">

                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                        <title>Check</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                           sketch:type="MSPage">
                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                  id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475"
                                  fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                        </g>
                    </svg>

                </div>
                <div class="dz-error-mark">

                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                        <title>error</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                           sketch:type="MSPage">
                            <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474"
                               stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                      id="Oval-2" sketch:type="MSShapeGroup"></path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>{{--End of Dropzone Preview Template--}}


        <div class="hotel_image">
            @if($hotel_image != null)
                <div class="row">
                    @foreach($hotel_image as $image)
                        <div class="col-md-2" style="border: 2px solid black;">
                            <img src="{{asset('/images/upload/'.$image["resized_name"])}}"
                                 class="exist_hotel_img img-responsive">
                            <li class="del_img" value="{{$image['id']}}">Delete Image</li>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


    </div>    <!-- end of .row (form) -->



@stop

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>


    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>

    <script>
        var total_photos_counter = 0;
        var url = '<?php echo route('hotel.edit', $hotel->id)?>';

        Dropzone.options.myDropzone = {
            uploadMultiple: true,
            parallelUploads: 2,
            maxFilesize: 16,
            previewTemplate: document.querySelector('#preview').innerHTML,
            addRemoveLinks: true,
            dictRemoveFile: 'Remove file',
            dictFileTooBig: 'Image is larger than 16MB',
            timeout: 10000,

            init: function () {
                this.on("removedfile", function (file) {
                    $.post({
                        url: '/images-delete',
                        data: {id: file.name, _token: $('[name="_token"]').val()},
                        dataType: 'json',
                        success: function (data) {
                            total_photos_counter--;
                            $("#counter").text("# " + total_photos_counter);
                        }
                    });
                });
            },
            success: function (file, done) {
                total_photos_counter++;
                $("#counter").text("# " + total_photos_counter);

                //alert('success.');

                $('.hotel_image').load(url + ' .hotel_image', function () {
                    $(".del_img").click(function () {
                        var image_id = $(this).val();
                        DeleteImage(image_id);
                    });

                    function DeleteImage(image_id) {
                        $.ajax({
                            url: 'deleteimg',
                            type: 'POST',
                            async: false,
                            data: {
                                _token: CSRF_TOKEN,
                                image_id: image_id
                            },
                            dataType: 'JSON',
                            beforeSend: function () {

                            },
                            success: function (data) {

                                $('.hotel_image').load(url + ' .hotel_image', function () {

                                    $(".del_img").click(function () {
                                        var image_id = $(this).val();
                                        DeleteImage(image_id);
                                    });

                                });
                            }
                        });
                    }
                });

            }
        };
    </script>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(".del_img").click(function () {

            var image_id = $(this).val();

            DeleteImage(image_id);
        });


        function DeleteImage(image_id) {
            $.ajax({
                url: 'deleteimg',
                type: 'POST',
                async: false,
                data: {
                    _token: CSRF_TOKEN,
                    image_id: image_id
                },
                dataType: 'JSON',
                beforeSend: function () {

                },
                success: function (data) {

                    $('.hotel_image').load(url + ' .hotel_image', function () {

                        $(".del_img").click(function () {
                            var image_id = $(this).val();
                            DeleteImage(image_id);
                        });

                    });
                }
            });
        }
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

            var marker = new H.map.Marker({
                lat:@if($hotel->coordi_x != null) {{$hotel->coordi_x}} @else {{'22.296957'}} @endif,
                lng:@if($hotel->coordi_y != null) {{$hotel->coordi_y}} @else {{'114.172199'}} @endif});
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
                center: {
                    lat:@if($hotel->coordi_x != null) {{$hotel->coordi_x}} @else {{'22.296957'}} @endif,
                    lng:@if($hotel->coordi_y != null) {{$hotel->coordi_y}} @else {{'114.172199'}} @endif
                },
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