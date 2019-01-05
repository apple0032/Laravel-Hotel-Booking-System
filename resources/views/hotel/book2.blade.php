@extends('main')

@section('title', '| Booking')

@section('stylesheets')

{!! Html::style('css/parsley.css') !!}
{!! Html::style('css/select2.min.css') !!}
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

@endsection

@section('content')

<div class="row page_row">
    <div class="col-md-8">
        <h1>Booking</h1>
        <hr>
        {!! Form::open(array('route' => 'hotel.store', 'data-parsley-validate' => '', 'files' => true)) !!}
        {{ Form::label('title', 'Name:') }}
        {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('phone', 'Phone:') }}
        {{ Form::text('phone', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '15')) }}

        {{ Form::submit('Create Hotel', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}

    </div>
    <div class="col-md-4">
        calendar here.
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

@endsection
