@extends('pattern')
@section('nav')
@endsection

@section('form')
    <form method="post" action="{{route('add_news')}}" enctype="multipart/form-data">
        {{@csrf_field()}}
        <p>Категория
            <select name="category_id">
                @foreach($query as $i)
{{--                    @if($course==$i->id)--}}
{{--                        <option value="{{$i->id}}" selected>{{$i->category_name}}</option>--}}
{{--                    @endif--}}
{{--                    @if($course!=$i->id)--}}
                        <option selected value="{{$i->id}}">{{$i->category_name}}</option>
{{--                    @endif--}}
                @endforeach
            </select></p>
        <p>Название курса<input type="text" placeholder="Математика" name="name_course"></p>
        <p>Описание курса<input type="text" placeholder="Математика - крутой предмет, учите ребята" name="description"></p>
        <p>Дата начала курса<input type="datetime-local" placeholder="2023-01-06" name="begin"></p>
        <p>Кол-во мест <input type="number" placeholder="5" name="number"></p>
        <p>Картинка <input type="file" name="image"></p>
        <input type="submit" value="Добавить">
    </form>
    @if(count($errors)>0)
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
@endsection
