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
//Route::post('/api/saida/store', 'SaidaControllerApi@store');

Route::get('/phpinfo', function () {
    echo phpinfo();
    return;
});

Route::get('/', function () {
    return view('home');
});
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/alunos/chamada', 'AlunoController@chamadapagina')->name('alunos.chamadapagina');
Route::put('/alunos/{id}', ['uses' => 'AlunoController@chamada', 'as' =>'alunos.chamada']);
Route::get('/admin/create', ['uses' => 'RegisterControllerAdmin@showRegistrationForm']);
Route::post('/admin/store', ['uses' => 'RegisterControllerAdmin@register'])->name('admins.store');

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/perfil', 'AdminController@perfil');
    Route::post('/perfil', 'AdminController@avatar');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@Login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

Route::prefix('alunos')->group(function() {
    Route::get('/create', 'AlunoController@create')->name('alunos.create');
    Route::get('/{id}', ['uses' => 'AlunoController@show', 'as' => 'alunos.show']);
    Route::get('/admin/{id}', ['uses' => 'AlunoController@showAdmin', 'as' => 'alunos.showadmin'])->middleware('auth:admin');
    Route::post('/', ['uses' => 'AlunoController@store', 'as' => 'alunos.store']);
    Route::get('/{id}/edit', ['uses' => 'AlunoController@edit', 'as' => 'alunos.edit']);
    Route::put('/{id}', ['uses' => 'AlunoController@update', 'as' => 'alunos.update']);
    Route::delete('/{id}', ['uses' => 'AlunoController@destroy', 'as' => 'alunos.destroy']);
    Route::get('/', 'AlunoController@index')->name('alunos.index');
});

Route::prefix('frequencia')->group(function() {
    Route::get('/create', 'FrequenciaController@create')->name('frequencia.create')->middleware('auth:admin');
    Route::get('/problema', 'FrequenciaController@problema')->name('frequencia.problema')->middleware('auth:admin');
    Route::get('/problema/saida', 'FrequenciaController@problemaOut')->name('frequencia.problemaout')->middleware('auth:admin');
    Route::get('/calendar', 'FrequenciaController@calendario')->name('frequencia.calendar')->middleware('auth');
    Route::post('/', ['uses' => 'FrequenciaController@store', 'as' => 'frequencia.store'])->middleware('auth:admin');
    Route::get('/ocorrencias', ['uses' => 'FrequenciaController@ocorrencias', 'as' => 'frequencia.ocorrencias'])->middleware('auth:admin');
    Route::get('/{id}/edit', ['uses' => 'FrequenciaController@edit', 'as' => 'frequencia.edit']);
    Route::put('/{id}', ['uses' => 'FrequenciaController@update', 'as' => 'frequencia.update']);
    Route::delete('/{id}', ['uses' => 'FrequenciaController@destroy', 'as' => 'frequencia.destroy']);
    Route::get('/{id}', ['uses' => 'FrequenciaController@show', 'as' => 'frequencia.show'])->middleware('auth');
    Route::get('/admin/{id}', ['uses' => 'FrequenciaController@showAdmin', 'as' => 'frequencia.showadmin'])->middleware('auth:admin');
    Route::get('/', 'FrequenciaController@index')->name('frequencia.index');
});

Route::prefix('saida')->group(function() {
    Route::get('/', ['uses' => 'SaidaController@index', 'as' => 'saida.index'])->middleware('auth:admin');
    Route::post('/', ['uses' => 'SaidaController@store', 'as' => 'saida.store'])->middleware('auth:admin');
    Route::get('/{id}/edit', ['uses' => 'SaidaController@edit', 'as' => 'saida.edit']);
    Route::put('/{id}', ['uses' => 'SaidaController@update', 'as' => 'saida.update']);
    Route::delete('/{id}', ['uses' => 'SaidaController@destroy', 'as' => 'saida.destroy']);
    Route::get('/{id}', ['uses' => 'SaidaController@show', 'as' => 'saida.show'])->middleware('auth');
    Route::get('/fetch/{id}', ['uses' => 'SaidaController@fetch', 'as' => 'saida.fetch']);
    Route::post('/post', ['uses' => 'SaidaController@post', 'as' => 'saida.post']);
    Route::get('/create', 'SaidaController@create')->name('saida.create')->middleware('auth:admin');
});

Route::prefix('cardapio')->group(function() {
    Route::get('/', ['uses' => 'FoodController@index', 'as' => 'food.index'])->middleware('auth:admin');
    Route::post('/', ['uses' => 'FoodController@store', 'as' => 'food.store'])->middleware('auth:admin');
    Route::get('/{id}/edit', ['uses' => 'FoodController@edit', 'as' => 'food.edit']);
    Route::put('/{id}', ['uses' => 'FoodController@update', 'as' => 'food.update']);
    Route::delete('/{id}', ['uses' => 'FoodController@destroy', 'as' => 'food.destroy']);
    Route::get('/{id}', ['uses' => 'FoodController@show', 'as' => 'food.show'])->middleware('auth');
    Route::get('/fetch/{id}', ['uses' => 'FoodController@fetch', 'as' => 'food.fetch']);
    Route::post('/post', ['uses' => 'FoodController@post', 'as' => 'food.post']);
    Route::get('/create', 'FoodController@create')->name('food.create')->middleware('auth:admin');
});

Route::get('perfil', 'UserController@perfil');
Route::post('perfil', 'UserController@avatar');

Route::get('/teste', function () {
    return view('teste');
});

Route::get('/marcarlida', function(){
    auth()->user()->unreadNotifications->markAsRead();
});

Route::get('/api/count', 'FrequenciaController@count');
