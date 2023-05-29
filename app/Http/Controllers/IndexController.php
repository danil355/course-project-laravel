<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Course_user;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IndexController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function Admin_View(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('police_admin');
        $all_course = Course::all();
        $all_course_user = Course_user::all();
        return view('admin')->
        with('query', $this->HeaderQuery())->
        with('all_course', $all_course)->
        with('all_course_user', $all_course_user);
    }

    public function CheckEnroll(): array
    {
        $flag = [];//Массив в котором будут хранится id курсов

        foreach (Course::all() as $i)
        {
            if(Auth::user() != null) {
                $query_course_user = Course_user::where('id_user', Auth::user()->id)->where('id_course', $i->id)->exists();
                $query_course = Course::find($i->id);//Находим id курса
                $now = Carbon::parse(Carbon::now());//Находим текущее время
                $date = Carbon::parse($query_course->begin);//Находим нашу дату с бд

                if ($query_course_user) $flag[$i->id] = 1;
                else if ($query_course->number < 1) $flag[$i->id] = 2;
                else if ($now > $date) $flag[$i->id] = 3;
                else $flag[$i->id] = 0;
            }
        }
        return $flag;
    }


    public function Index_View(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $all_course = Course::all();
        return view('index')->
        with('query', $this->HeaderQuery())->
        with('list_filter', $all_course)->
        with('flag', $this->CheckEnroll());
    }

    /**
     * @throws AuthorizationException
     */
    public function Description_Course($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
//        dd($id);
        $name = Course::all()->where('id', $id)->first();
        $courses = Course_user::where('id_course', $id)->count();//Нахождение определенного курса, чтобы посчитать кол-во человек записанных на курс
        $max = $courses + $name->number;
        $min = $max - $name->number;
//        dd($name);
        return view('description-course')->
        with('name', $name)->
        with('query', $this->HeaderQuery())->
        with('max', $max)->
        with('min', $min);
    }

    public function CategoryList($course): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $name = Course::all()->where('category_id', $course);
        return view('course')->with('name', $name)->with('query', $this->HeaderQuery());
    }

    public function HeaderQuery()
    {
        return Category::select('category_name', 'id')->get();//Чтобы каждый раз не писать этот запрос (Header)
    }

    public function ButtonClick(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $filter = null;
        if($request->input('radio') == 'Нет мест')
        {
            $filter = Course::where('number', 0)->get();
        }

        else if($request->input('radio') == 'Активна')
        {
            $filter = Course::where('begin', '>', Carbon::now())->get();
        }

        else if($request->input('radio') == 'Прошла')
        {
            $filter = Course::where('begin', '<', Carbon::now())->get();
        }

        else if($request->input('radio') == 'Все курсы')
        {
            $filter = Course::all();
        }

        $query = $this->HeaderQuery();
        return view('index')->with('list_filter', $filter)->with('query', $query)->with('flag', $this->CheckEnroll());
    }

    public function Enroll(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

//        dd($request->input('id_course'), $request->input('id_user'));
        $id_user = $request->input('id_user');
        $id_course = $request->input('id_course');
        $query_course = Course::find($id_course);//Находим id курса
        //Проверяем запись на курс пользователя. exists() - существует.
            $numbers = $query_course->number -= 1;
            Course::where('id', $id_course)->update(['number' => $numbers]);
            $data = $request->all();
            $course_user = new Course_user();
            $course_user->fill($data);
            $course_user->save();
            return redirect('/list');

    }

    public function Warning()
    {
        $message = null;
        return view('warning')->with('query', $this->HeaderQuery())->with('message', $message);
    }

    public function List()
    {
        $this->authorize('police_user');
        $course = Course::all();
        $all = Course_user::join('Course', 'Course.id', '=', 'Course_user.id_course')->select('Course_user.id', 'Course_user.id_course', 'Course.name_course', 'Course.begin', 'Course.number', 'Course.image')->where('Course_user.id_user', Auth::id())->get();
        return view('list')->with('query', $this->HeaderQuery())->with('all', $all)->with('course', $course);
    }

    public function EnrollDelete(Course_user $id, Request $request)
    {
        $query = Course::find($request->input('id_course'));
        $now=Carbon::parse(Carbon::now());
        $date=Carbon::parse($query->begin);
        $count = $now->diffInHours($date);
//        dd($count);
//        $date_diff=$now->diffInDays($date);
//        $count = $now - $date;
//        dd();
//        dd($date_diff);
        if($now < $date and $count >= 24)
        {
            $id->delete();
            $number = $query->number += 1;
            Course::where('id', $query)->update(['number' => $number]);
            $query->save();
            return redirect('/list');
        }

        else
        {
            $message = Auth::user()->name . ", вы не можете отписаться, так как уже прошел срок возможности отписки от курса. ";
            return view('/warning')->with('message', $message)->with('query', $this->HeaderQuery());
        }
    }

    public function View_Add()
    {
        $this->authorize('police_admin');
        return view('view_add')->with('query', $this->HeaderQuery());
    }

    public function Form_Add(Request $request)
    {
        $this->validate
        (
            $request,
            [
                'category_id' => 'required',
                'name_course' => 'required|string',
                'description' => 'required|string',
                'begin' => 'required|after:today',
                'number' => 'required|int|min:1|max:20',
                'image' => 'nullable|image'
            ]
        );

        $message = 'Есть уже данная запись в БД либо нельзя добавить в такое время';
        $exists = Course::where('name_course', $request->input('name_course'))->exists();
        if(!$exists and $request->input('begin') > Carbon::now())
        {
            $course = new Course();
            $course->category_id = $request->input('category_id');
            $course->name_course = $request->input('name_course');
            $course->description = $request->input('description');
            $course->begin = $request->input('begin');
            $course->number = $request->input('number');
            if ($request->hasFile('image'))
            {
                $image = $request->file('image');
                $path = $image->hashName();
                if (!Storage::disk('public')->exists($path))
                {
                    $path = $image->store('', 'public');
                }
                $course->image = $path;
            }
            $course->save();

            return redirect('/admin');
        }

        else
        {
            return view('warning')->with('message', $message)->with('query', $this->HeaderQuery());
        }

    }

    public function ListCourseUser()
    {
            $course_user = Course_user::join('Course', 'Course.id', '=', 'Course_user.id_course')
            ->join('users', 'users.id', '=', 'Course_user.id_user')->groupBy('Course.name_course', 'users.name', 'Course_user.id')
            ->select('Course_user.id', 'Course.name_course', 'users.name')->get();
        return view('list-course-user')->with('course_user', $course_user)->with('query', $this->HeaderQuery());
    }

    public function DeleteCourseUser(Course_user $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
//        dd($id->id_user);
        $id_course = Course::find($id->id_course);
        $number = $id_course->number += 1;
        Course::where('id', $id_course)->update(['number' => $number]);
        $id_course->save();
//        dd($id_course, $number, Course::where('id', $id_course)->update(['number' => $number]));
        $id->delete();

//        Course::all()->where('')
        return redirect('/list/course/user');
    }

    public function DeleteCourse(Course $id)
    {
        $id->delete();
        return redirect('/admin');
    }
}
