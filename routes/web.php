<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;
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
    return view('shipbay');
});

Route::get('/address', function(){
    return view('address');
});

Route::get('/calendar', function(){
   /*  $e = Event::get();
    dd($e); */
});
/* 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); */
Route::get('/{catchall?}','AppController@show')->where('catchall','^(?!api).*$')->name('administration');

