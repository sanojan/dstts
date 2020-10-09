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
})->name('welcome');

//Route::get('/letters', function () {
//    return view('letters.create');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//<<<<<<< HEAD

Route::resource('users', 'UsersController')->middleware('auth');
//=======
Route::resource('users', 'UsersController');
//>>>>>>> 8a0e7684981414db713d4739d3a1c9d99080b41a
Route::resource('letters', 'LettersController')->middleware('auth');
Route::resource('tasks', 'TasksController')->middleware('auth');
Route::resource('histories', 'HistoriesController')->middleware('auth');
Route::get('get-workplaces-list','WorkplacetypeController@getWorkplaces');
//Route::resource('workplace', 'WorkplaceController');