<?php

use GetTheTrophy\Http\Controllers\BotController;
use Illuminate\Support\Facades\Route;

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

Route::get('/webchat', function () {
    return view('webchat');
});

Route::get('/chatframe', function () {
    return view('chatframe');
});

Route::match(['get', 'post'], '/bot', [BotController::class, 'handle']);
