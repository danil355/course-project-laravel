@extends('pattern')

@section('nav')
@endsection

@section('section')
    {{--    <section class="eight columns">--}}
    @foreach($name as $i)
        <article class="blog_post">
            <div class="nine columns">
                <a href="{{route('Statya', ['id' => $i->id])}}"><p>{{$i->name_course}}</p></a>
                <p>{{$i->description}}</p>
            </div>
        </article>
    @endforeach
    {{--    </section>--}}
@endsection

@section('images')
@endsection

@section('footer')
@endsection
