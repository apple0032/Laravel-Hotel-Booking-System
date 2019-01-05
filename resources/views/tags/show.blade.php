@extends('main')

@section('title', "| $tag->name Tag")

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>{{ $tag->name }} Tag
                <small>{{ count($hotel_tags) }} Hotels</small>
            </h1>
        </div>
        <div class="col-md-2">
            <a href="{{ route('tags.index') }}" class="button button-3d button-default button-rounded three_d_btn"
               style="margin-top:20px;">Back</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('tags.edit', $tag->id) }}"
               class="button button-3d button-primary button-rounded three_d_btn" style="margin-top:20px;">Edit</a>
        </div>
        <div class="col-md-2">
            {{ Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'DELETE']) }}
            {{ Form::submit('Delete', ['class' => 'button button-3d button-caution button-rounded three_d_btn', 'style' => 'margin-top:20px;']) }}
            {{ Form::close() }}
        </div>
    </div>

    <div class="row page_row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @if($hotel_tags != null)
                    @foreach ($hotel_tags as $key => $hotel_tag)
                        <tr>
                            <th>{{ $key+1 }}</th>
                            <th>{{ $hotel_tag['id'] }}</th>
                            <td>{{ $hotel_tag['name'] }}</td>
                            <td>
                                <a href="{{ route('hotel.show', $hotel_tag['id']) }}" class="btn btn-default btn-sm"><i
                                            class="fas fa-eye"></i></a>
                                <a href="{{ route('hotel.edit', $hotel_tag['id']) }}" class="btn btn-default btn-sm"><i
                                            class="fas fa-pen-nib"></i></a>
                                <a href="hotel/{{ $hotel_tag['id'] }}/delete" class="btn btn-default btn-sm"><i
                                            class="fas fa-trash"></i></a>

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection