<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_user extends Model
{
    use HasFactory;
    protected $table = 'Course_user';
    protected $fillable = ['id', 'id_user', 'id_course'];
}
