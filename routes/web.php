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
    Route::resource('sellers', 'SellerController')->middleware('auth');
    Route::resource('workplaces', 'WorkplaceController')->middleware('auth');
    Route::resource('complaints', 'ComplaintController');

    Route::get('get-workplaces-table','WorkplaceController@workplacesAll')->name('workplaces.all');
    Route::get('/travelpasses/{id}/pdf','TravelPassController@newPDF')->name('travelpass.pdf');
    Route::get('/travelpasses/{id}/preview_pdf','TravelPassController@previewPDF')->name('travelpass.preview');
    Route::get('/travelpasses/{id}/final_pdf','TravelPassController@finalPDF')->name('travelpass.final');
    Route::get('/travelpasses/{id}/application_pdf','TravelPassController@appliPDF')->name('travelpass.appli');
    Route::get('report','TravelPassController@reportExport')->name('travelpass.report');
    
    Route::get('get-workplaces-table','WorkplaceController@workplacesAll')->name('workplaces.all');
    Route::get('get-workplaces-list','WorkplacetypeController@getWorkplaces');
    Route::get('get-sellers-list','SellerController@getSellers');
    Route::get('get-seller-details','SellerController@getSeller');
    Route::get('getWorkplaces','UsersController@getWorkplaces');
    Route::get('get-gndivision-list','GNDivisionController@getGNDivisions');

    Route::get('/foo', function () {
        Artisan::call('storage:link');
    });


    //Route::resource('workplace', 'WorkplaceController');

});