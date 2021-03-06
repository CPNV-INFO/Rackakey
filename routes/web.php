<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/home', 'HomeController@index')->name('home');

/* USBS */
Route::resource('usbs','UsbController');
Route::post('usbs/restore/{id}','UsbController@restore');
Route::post('usbs/initialize/{id}','UsbController@initialize');
Route::post('usbs/out/{id}','UsbController@out');
Route::post('usbs/in/{id}','UsbController@in');

/* RESERVATION*/
Route::resource('reservation',      'ReservationController');
Route::get('reservation_show',      'ReservationController@showReservations');
Route::get('reservation_create',    'ReservationController@createReservations');

/* FILE */
Route::resource('file',     'FileController');
Route::get('files/{id}',    'FileController@showFilesList');

/* FILE UPLOAD */
Route::get('getMaxFileUploads', 'FileUploadController@getMaxFileUploads');
Route::get('getPostMaxSize', 'FileUploadController@getPostMaxSize');
