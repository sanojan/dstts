<?php

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

//Route::get('/letters', function () {
//    return view('letters.create');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

<<<<<<< HEAD
Route::resource('users', 'UsersController');
Route::resource('letters', 'LettersController');
=======
Route::view('/letters', 'letters.create')->name('letters');

Route::resource('users', 'UsersController');
>>>>>>> 556fa06127669a26156060815574d712a8305ff9
