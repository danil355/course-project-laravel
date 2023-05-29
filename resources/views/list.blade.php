@extends('pattern')
@section('nav')
@endsection

@section('section')
    @foreach($all as $i)
        <div class="section_main">
            <div class="row">
                <section class="eight columns">
                    <article class="blog_post">
                        <div class="three columns">
                            @if(File::exists(public_path('storage/images/'.$i->image)))
                                <a href="#" class="th"><img src="{{asset('storage/images/'.$i->image)}}" alt="desc" /></a>
                            @else <a href="#" class="th"><img src="{{asset('storage/'.$i->image)}}" alt="desc" /></a>
                            @endif
                        </div>
                        <div class="nine columns">
                            <a href="#"><h4>{{$i->name_course}}</h4></a>
                            <p>Количество: {{$i->number}}</p>
                            @can('police_user')
                                <form method="post" action="{{route('enroll_delete', ['id' => $i->id])}}">
                                    {{@csrf_field()}}
                                    <input type=hidden name="_method" value="DELETE">
                                    <input type="hidden" name="id_course" value="{{$i->id_course}}">
{{--                                    <input type="hidden" name="id_user" value="{{\Illuminate\Support\Facades\Auth::id()}}">--}}
                                    <p><input type="submit" value="Отписаться"></p>
                                </form>
                            @endcan
                        </div>
                    </article>
                </section>
            </div>
        </div>
    @endforeach
@endsection

@section('image')
@endsection

@section('footer')
@endsection
