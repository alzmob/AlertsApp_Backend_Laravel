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
})->name('home');

Auth::routes(['verify' => false]);

// Route::get('/home', 'HomeController@index')->name('home');

Route::view('dashboard', 'admin.dashboard');

Route::group(['as' => 'app.', 'prefix' => 'app', 'middleware' => ['auth', 'authorize', 'verified']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::delete('/media/{id}/destroy', 'MediaController@destroy')->name('media.destroy');

    Route::resource('cities', 'CityController');

    Route::resource('alerts', 'AlertController');
    Route::post('alerts/{id}/upload', 'AlertController@upload')->name('alerts.upload');

    Route::group(['as' => 'alerts.', 'prefix' => 'alerts/{alertId}',], function () {
        Route::resource('updates', 'AlertUpdateController')->except(['index','create','edit','update']);
        Route::resource('comments', 'AlertCommentController')->except(['index','create','edit','update']);
    });


    Route::resource('permissions', 'PermissionController')->except(['show', 'edit', 'update']);
    Route::resource('roles', 'RoleController')->except(['show']);
    Route::resource('users', 'UserController');
});

