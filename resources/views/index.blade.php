@extends('pattern')
@section('nav')
@endsection

@section('header')
    <div class="row">
        <h1>Языковая школа LINGVO</h1>
    </div>
@endsection

@can('police_user')
@section('form')
    <form style="text-align: center;" method="get" action="{{route('Button')}}">
        <label>Все курсы<input type="radio" value="Все курсы" name="radio"></label>
        <label>Активна<input type="radio" value="Активна" name="radio"></label>
        <label>Прошла<input type="radio" value="Прошла" name="radio"></label>
        <label>Нет мест<input type="radio" value="Нет мест" name="radio"></label>
        <input type="submit" value="Выбрать">
    </form>
@endsection
@endcan

@section('section')
    @foreach($list_filter as $j)
    <div class="section_main">
        <div class="row">
            <section class="eight columns">
                <article class="blog_post">
                    <div class="three columns">
                            @if(File::exists(public_path('storage/images/'.$j->image)))
                                <a href="{{ route('Statya', ['id' => $j->id]) }}" class="th"><img src="{{asset('storage/images/'.$j->image)}}" alt="desc" /></a>
                            @else
                                <a href="{{ route('Statya', ['id' => $j->id]) }}" class="th"><img src="{{asset('storage/'.$j->image)}}" alt="desc" /></a>
                            @endif
                    </div>
                    <div class="nine columns">
                        <a href="{{ route('Statya', ['id' => $j->id]) }}"><h4>{{$j->name_course}}</h4></a>
                        <p>Количество: {{$j->number}}</p>
{{--                        <p>Общее кол-во: {{$count}}</p>--}}
                        @can('police_user')
                        <form method="get" action="{{route('enroll')}}">
                            {{@csrf_field()}}
                            <input type="hidden" name="id_course" value="{{$j->id}}">
                            <input type="hidden" name="id_user" value="{{\Illuminate\Support\Facades\Auth::id()}}">

{{--                            @foreach($flag as $k)--}}
                            @if($flag[$j->id] == 1)
                                <p style="color: red; font-weight: bold">Вы записаны на курс</p>
                            @elseif($flag[$j->id] == 2)
                                <p  style="color: red; font-weight: bold">Мест не осталось</p>
                            @elseif($flag[$j->id] == 3)
                                <p style="color: red; font-weight: bold">Не успели</p>
                            @elseif($flag[$j->id] == 0)
                            <p><input type="submit" value="Записаться"></p>
                            @endif
{{--                            @endforeach--}}
                        </form>
                        @endcan
                    </div>
                </article>
            </section>
        </div>
    </div>
    @endforeach
    @if(count($errors)>0)
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
@endsection

@section('images')
@endsection

@section('footer')
@endsection
