<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\MailSendController;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PrefCityController;
use App\Http\Controllers\SimpleLoginController;
use App\Http\Controllers\ProfileController;
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

//簡単ログイン
Route::get('/simpleLogin', [SimpleLoginController::class, 'guestLogin']);
//ログイン
Route::get('/login', [LoginController::class, 'login']);
//登録
Route::post('register/reg', [RegisterController::class, 'register']);
Route::get('/pref_city', [PrefCityController::class, 'prefCity']);
//プロフィール
Route::get('/profile/get', [ProfileController::class, 'get']);
Route::post('/profile/update', [ProfileController::class, 'update']);
//TODO
Route::post('todo/add', [TodoController::class, 'add']);
Route::get('todo/get', [TodoController::class, 'get']);
Route::get('todo/action', [TodoController::class, 'action']);
Route::get('todo/update', [TodoController::class, 'update']);
Route::get('todo/delete', [TodoController::class, 'delete']);
//メール
Route::get('/mail', [MailSendController::class, 'send']);
//アルバム
Route::post('album/albumDetail/upload', [AlbumController::class, 'upload']);
// Route::post('album/albumDetail/upload', function(){
//     dd(request()->all());
//});
//カレンダー
Route::get('album/albumInfo', [CalendarController::class, 'albumInfo']);

// Route::post('regist/reg', function(){
//     dd(request()->all());
// });
//地図
Route::get('/json', [JsonController::class, 'getJson']);
