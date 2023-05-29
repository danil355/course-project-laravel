<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $name_course
 * @property mixed $number
 * @property mixed $begin
 * @property mixed $description
 * @property false|mixed|string $image
 * @property mixed $category_id
 */
class Course extends Model
{
    use HasFactory;

    protected $table = 'Course';
    public $fillable = ['id', 'name_course', 'description', 'begin', 'number', 'image', 'category_id'];
}
