<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\MailSendController;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\JsonController;
//use App\Http\Controllers\RegistController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::get('/', function () {
  return view('welcome');
});

//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('register/reg', [RegisterController::class, 'register']);
// Route::post('register/reg', function(){
//     dd(request()->all());
// });

Route::post('todo/add', [TodoController::class, 'add']);
Route::get('todo/get', [TodoController::class, 'get']);
Route::get('todo/action', [TodoController::class, 'action']);
Route::get('todo/update', [TodoController::class, 'update']);
Route::get('todo/delete', [TodoController::class, 'delete']);

Route::get('/mail', [MailSendController::class, 'send']);

Route::post('album/albumDetail/upload', [AlbumController::class, 'upload']);
// Route::post('album/albumDetail/upload', function(){
//     dd(request()->all());
//});
//カレンダー
Route::get('album/albumInfo', [CalendarController::class, 'albumInfo']);

// Route::post('regist/reg', function(){
//     dd(request()->all());
// });
Route::get('/json', [JsonController::class, 'getJson']);
