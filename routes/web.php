<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QaGeneratorsController;
use App\Http\Controllers\CoursesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/', 'QaGeneratorsController@showFormGenerate')->name('create');
Route::get('/', [QaGeneratorsController::class, 'showFormGenerate'])->name('create');
Route::post('/generates', [QaGeneratorsController::class, 'store']);

Route::resource('courses', CoursesController::class);

