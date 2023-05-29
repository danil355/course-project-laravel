@extends('pattern')
@section('nav')
@endsection

@section('header')
    <h2>Список пользователей</h2>
@endsection

@section('section')
    <table style="border: 1px solid grey">
        <tr>
            <th>Название курса</th>
            <th>Имя пользователя</th>
        </tr>
        @foreach($course_user as $i)
        <tr>
            <td style="border: 1px solid grey">{{$i->name_course}}</td>
            <td style="border: 1px solid grey">{{$i->name}}</td>
            <form method="post" action="{{route('delete-course-user', ['id' => $i->id])}}">
                {{@csrf_field()}}
                <input type=hidden name="_method" value="DELETE">
                <td style="border: 1px solid grey"><input style="border-radius: 5px; background-color: red;" type="submit" value="Удалить запись"></td>
            </form>
        </tr>
        @endforeach
    </table>

@endsection
