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
	//return 'Home';
})->name('welcome');

Route::get('/usuarios', 'UserController@index')->name('users');

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.create');

Route::post('/usuarios/crear','UserController@store')->name('users.store');


/*Route::get('/usuarios/{id}', function ($id) {
    return '<h1>Mostrando Detalle del Usuario: '.$id.'</h1>';
});*/

Route::get('/usuarios/{user}', 'UserController@show')->name('users.show');

Route::get('/usuarios/{user}/editar', 'UserController@edit')->name('users.edit');

Route::put('/usuarios/{user}', 'UserController@update')->name('users.update');

Route::delete('/usuarios/{user}', 'UserController@destroy')->name('users.destroy');

//

Route::get('/saludo/{name}/{nickname?}', function ($name,$nickname=null) {
	if($nickname){
		return '<h1>Bienvenido '.$name.', tu apodo es: '.$nickname.' </h1>';
	}else{
		return '<h1>Bienvenido '.$name.', no tienes apodo </h1>';
	}
})->name('saludo');



    
