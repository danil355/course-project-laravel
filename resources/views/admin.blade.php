@extends('pattern')
@section('nav')
@endsection
<!-- ######################## Header (featured posts) ######################## -->
@section('header')
    <div class="row">
        <h1>Языковая школа LINGVO</h1>
    </div>
@endsection

@can('police_admin')
@section('section')
    <div class="section_main">
        <div class="row">
            @foreach($all_course as $j)
            <section class="eight columns">
{{--                <h3> {{$j->name_course}}   </h3>--}}
                <article class="blog_post">
                    <div class="three columns">
                        @if(File::exists(public_path('storage/images/'.$j->image)))
                            <a href="{{ route('Statya', ['id' => $j->id]) }}" class="th" class="th"><img src="{{asset('storage/images/'.$j->image)}}" alt="desc" /></a>
                        @else
                            <a href="{{ route('Statya', ['id' => $j->id]) }}" class="th" class="th"><img src="{{asset('storage/'.$j->image)}}" alt="desc" /></a>
                        @endif
                    </div>
                    <div class="nine columns">
                        <a href="{{ route('Statya', ['id' => $j->id]) }}" class="th"><h4>{{$j->name_course}}</h4></a>
                        @php $flag = false; @endphp
                        @foreach($all_course_user as $i)
                            @if($i->id_course == $j->id)
                                @php $flag = true; break;  @endphp
                            @else
                                @php $flag = false; @endphp
                            @endif
                        @endforeach
                        @if($flag)
                            <p style="color: red; font-weight: bold;">Невозможно удалить</p>
                        @else
                        <form method="post" action="{{route('delete-course', ['id'=>$j->id])}}">
                            {{@csrf_field()}}
                            <input type=hidden name="_method" value="DELETE">
                            <p><input type="submit" value="Удалить"></p>
                        </form>
                        @endif
                    </div>
                </article>
            </section>
            @endforeach

            <section class="four columns">
                <H3></H3>
                <div class="panel">
                    <h3>Админ-панель</h3>
                    <ul class="accordion">
                        <li class="active">
                            <div class="title">
                                <a href="/main/view/add"><h5>Добавить курс</h5></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

    </div>
@endsection
@endcan

@section('images')
@endsection

@section('footer')
@endsection

