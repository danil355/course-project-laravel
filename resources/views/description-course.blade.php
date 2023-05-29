{{--@can('police_user')--}}
@extends('pattern')
@section('nav')
@endsection

{{--@foreach($name as $name)--}}
    @section('header')
        <div class="row">
            <article>
                <div class="twelve columns">
                    <h1>{{$name->name_course}}</h1>
                    <p class="excerpt">
                        Начало курса: <b>{{$name->begin}}</b>.
                    </p>
                    <p class="excerpt">
                        Количество мест: <b>{{$min}}/{{$max}}</b>.
                    </p>
                </div>
            </article>
        </div>
    @endsection

    @section('section')
        <div class="row">
            @if(File::exists(public_path('storage/images/'.$name->image)))
                <p> <img src="{{asset('storage/images/'.$name->image)}}" alt="desc" width=400 align=left hspace=30>{{ $name->description }}</p>
            @else
                <p> <img src="{{asset('storage/'.$name->image)}}" alt="desc" width=400 align=left hspace=30>{{ $name->description }}</p>
            @endif
        </div>
    @endsection
{{--@endforeach--}}

@section('images')
@endsection

@section('footer')
@endsection
{{--@endcan--}}
