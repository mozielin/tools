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

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );

Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@getprofile')->name('profile');

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

Route::get('/import_edit', 'ImportController@EditView')->name('import_edit');

Route::get('/import_delete/{id}', 'ImportController@Delete')->name('import_delete');

Route::get('/user_view/{user_id}', 'UserController@view')->name('user_view');


//若要驗證加入,'middleware' => ['role:Admin']
Route::group(['prefix'=>'user'], function(){
      Route::get('/', 'UserController@index')->name('user_index');
      Route::get('byid/{order}','UserController@byid')->name('user_byid');
      Route::get('byname/{order}','UserController@byname')->name('user_byname');
      Route::get('bygroup/{order}','UserController@bygroup')->name('user_bygroup');
      Route::get('byrole/{order}','UserController@byrole')->name('user_byrole');
      Route::get('bylogin/{order}','UserController@bylogin')->name('user_bylogin');
      //Route::get('view/{user_id}', 'UserController@view')->name('user_view');
      Route::get('create',['middleware' => ['permission:user_create'], 'uses' => 'UserController@create'])->name('user_create');
      Route::post('store',['middleware' => ['permission:user_create'], 'uses' => 'UserController@store'])->name('user_store');
      Route::get('edit/{user_id}',['middleware' => ['permission:user_edit'], 'uses' => 'UserController@edit'])->name('user_edit');
      Route::post('update/{user_id}', ['middleware' => ['permission:user_edit'], 'uses' =>'UserController@update'])->name('user_update');
      Route::get('delete/{user_id}',['middleware' => ['permission:user_delete'], 'uses' => 'UserController@delete'])->name('user_delete');
      Route::name('user_upload')->post('/upload/{user_id}','UserController@upload');
      Route::name('user_reset')->get('resetpassword/{user_id}','UserController@reset');
      Route::name('user_resetpwd')->post('resetpwd/{user_id}','UserController@resetpwd');
});

Route::group(['prefix'=>'role','middleware' => ['role:admin|devenlope']], function(){ 
      Route::name('role_index')->get('/', 'RoleController@index');
      Route::get('view/{role_id}', 'RoleController@view')->name('role_view');
      Route::get('create', 'RoleController@create')->name('role_create');
      Route::post('store', 'RoleController@store')->name('role_store');
      Route::get('edit/{role_id}', 'RoleController@edit')->name('role_edit');
      Route::post('/update/{id}', 'RoleController@update')->name('role_update');
      Route::get('delete/{role_id}', 'RoleController@delete')->name('role_delete');
});
Route::group(['prefix'=>'permission','middleware' => ['role:admin|devenlope']], function(){
      Route::name('permission_index')->get('/', 'PermissionController@index');
      Route::get('view/{permission_id}', 'PermissionController@view')->name('permission_view');
      Route::get('create', 'PermissionController@create')->name('permission_create');
      Route::post('store', 'PermissionController@store')->name('permission_store');
      Route::get('edit/{permission_id}', 'PermissionController@edit')->name('permission_edit');
      Route::post('/update/{id}', 'PermissionController@update')->name('permission_update');
      Route::get('delete/{permission_id}', 'PermissionController@delete')->name('permission_delete');
});


