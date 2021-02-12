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

Route::redirect('/', '/en');
Route::redirect('/home', 'en/home');

Route::group(['prefix' => '{language}'], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    //Route::get('/letters', function () {
    //    return view('letters.create');
    //});

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');




    Route::resource('users', 'UsersController')->middleware('auth');

    Route::resource('letters', 'LettersController')->middleware('auth');
    Route::resource('tasks', 'TasksController')->middleware('auth');
    Route::resource('histories', 'HistoriesController')->middleware('auth');
    Route::resource('complaints', 'ComplaintController');
    Route::get('get-workplaces-list','WorkplacetypeController@getWorkplaces');
    Route::get('getWorkplaces','UsersController@getWorkplaces');
    Route::get('get-gndivision-list','GNDivisionController@getGNDivisions');


    //Route::resource('workplace', 'WorkplaceController');

});