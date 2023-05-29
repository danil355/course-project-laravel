<?php

namespace App\Http\Controllers;

use App\Http\Resources\MasterClassResourceCollection;
use App\Models\Course;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function course()
    {
        return new MasterClassResourceCollection(Course::all());
    }

    public function courses(string $id)
    {
        $json = Course::select()->where('id','=',$id)->first();    if(!$json)
        abort(404);
    else    return new MasterClassResourceCollection(Course::select()->where('id','=',$id)->get());
}
}
