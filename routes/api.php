<?php

use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\QaGensController;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreGeneratorRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', CoursesController::class);
Route::apiResource('qa-generators', QaGensController::class);

Route::get('/qa-generators/bycourse/{id}', [QaGensController::class, 'showDataByCourseId']);
Route::post('/qa-generators/generate', [QaGensController::class, 'saveDataGenerate']);
