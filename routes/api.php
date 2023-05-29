<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students/tambah-data', [StudentController::class, 'store']);
Route::get('/generate-token', [StudentController::class, 'createToken']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::patch('/students/update/{id}', [StudentController::class, 'update']);
Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);
Route::get('/students/show/trash', [StudentController::class, 'trash']);
Route::get('/students/trash/restore/{id}', [StudentController::class, 'restore']);
Route::get('/students/trash/delete/permanent/{id}', [StudentController::class, 'perDel']);
 
