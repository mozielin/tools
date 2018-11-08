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

Route::get('/', function () {
    return view('welcome');
});


Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );

Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/firstsetpass', 'SocialAuthController@firstsetpass')->name('firstsetpass');

Route::get ( '/view', 'SocialAuthController@view' )->name('view');

Route::get ( '/firstlogin', 'SocialAuthController@firstlogin' )->name('firstlogin');

Route::get ( '/import', 'ImportController@getImport' )->name('import');

Route::post ( '/import/upload', 'ImportController@Upload' )->name('/import/upload');

Route::post ( '/import/upload_list', 'ImportController@Upload_list' )->name('/import/upload_list');

Route::get ( '/import_parse', 'ImportController@ParseImport' )->name('import_parse');

Route::post('/import_process', 'ImportController@ProcessImport')->name('import_process');

Route::post('/import_process_list', 'ImportController@ProcessImport_list')->name('import_process_list');

Route::get('/import_download/{filepath}/{listname}', 'ImportController@Download')->name('import_download');

Route::get('/import_list', 'ImportController@Importfromlist')->name('import_list');


