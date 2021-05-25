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
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/contact', 'HomeController@contact')->name('contact');



    Route::post('change-password', 'UsersController@changepassword')->name('change.password');
    Route::resource('users', 'UsersController')->middleware('auth');

    Route::resource('letters', 'LettersController')->middleware('auth');
    Route::resource('tasks', 'TasksController')->middleware('auth');
    Route::resource('files', 'FileController')->middleware('auth');
    Route::resource('histories', 'HistoriesController')->middleware('auth');
    Route::resource('travelpasses', 'TravelPassController')->middleware('auth');
    Route::resource('complaints', 'ComplaintController');

    Route::get('/travelpasses/{id}/pdf','TravelPassController@newPDF')->name('travelpass.pdf');
    //Route::get('/travelpasses/downloadPDF/{id}','TravelPassController@downloadPDF');
    
    Route::get('get-workplaces-list','WorkplacetypeController@getWorkplaces');
    Route::get('getWorkplaces','UsersController@getWorkplaces');
    Route::get('get-gndivision-list','GNDivisionController@getGNDivisions');


    //Route::resource('workplace', 'WorkplaceController');

});