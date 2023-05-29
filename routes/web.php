<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin', [\App\Http\Controllers\IndexController::class, 'Admin_View']);
Route::get('/index', [\App\Http\Controllers\IndexController::class, 'Index_View']);
Route::get('/course/{id}', [\App\Http\Controllers\IndexController::class, 'Description_Course'])->name('Statya')->middleware('auth');
Route::get('/button', [\App\Http\Controllers\IndexController::class, 'ButtonClick'])->name('Button');
Route::get('/enroll', [\App\Http\Controllers\IndexController::class, 'Enroll'])->name('enroll');
Route::delete('/enroll_delete/{id}', [\App\Http\Controllers\IndexController::class, 'EnrollDelete'])->name('enroll_delete');
Route::get('/warning', [\App\Http\Controllers\IndexController::class, 'Warning'])->name('warning');
Route::get('/list', [IndexController::class, 'List']);
Route::get('/main/view/add', [\App\Http\Controllers\IndexController::class, 'View_Add']);
Route::post('/main/form/add', [\App\Http\Controllers\IndexController::class, 'Form_Add'])->name('add_news');
Route::get('/list/course/user', [IndexController::class, 'ListCourseUser']);
Route::delete('/delete/course/user/{id}', [IndexController::class, 'DeleteCourseUser'])->name('delete-course-user');
Route::delete('/delete/course/{id}', [IndexController::class, 'DeleteCourse'])->name('delete-course');
Route::get('/category/{course}', [IndexController::class, 'CategoryList'])->name('Course_Id')->middleware('auth');
