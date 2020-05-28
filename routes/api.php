<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::get('me', 'AuthController@me');


Route::group(['middleware' => ['auth:api']], function () {

    // profile
    Route::get('profile', 'ProfileController@index');
    Route::put('profile', 'ProfileController@update');
    Route::put('change-password', 'ProfileController@changePassword');

    Route::get('cities', 'CityController@index');
    Route::get('my-alerts', 'MyAlertController@index');
    Route::apiResource('alerts', 'AlertController');
    Route::post('alerts/{id}/upload', 'AlertController@upload');
    Route::post('alerts/{id}/like/{type}', 'AlertController@like');
    Route::get('alerts/{id}/media', 'AlertController@media');

    // alerts comments
    Route::get('alerts/{alertId}/comments', 'AlertCommentController@index');
    Route::post('alerts/{alertId}/comments', 'AlertCommentController@store');
    Route::delete('alerts/{alertId}/comments/{id}', 'AlertCommentController@destroy');
    
    //device token 
    Route::post('device/register/{id}','AuthController@storeDeviceToken');
    
    // alerts updates
    Route::get('alerts/{alertId}/updates', 'AlertUpdateController@index');
    Route::post('alerts/{alertId}/updates', 'AlertUpdateController@store');
    Route::delete('alerts/{alertId}/updates/{id}', 'AlertUpdateController@destroy');

    // Alerts is_broadcasted = 0 to 1
    Route::get('alerts/get-alerts/broadcasted', 'AlertController@getAlertsBroadcasted');
    Route::post('alerts/update-alerts/broadcasted', 'AlertController@updateAlertsBroadcasted');
    Route::post('alerts/update-alerts/broadcasted/{alert_id}', 'AlertController@updateAlertsBroadcastedById');


    // Profile Picture Update of user
    Route::post('users/update-profile-picture', 'ProfileController@updateProfilePicture');
    // http://localhost:8000/api/v1/users/update-profile-picture  ** params (profile_picture)

    // Alerts total view count
    // Added in alert list or alert details view

    // Emoji expression count Api.Emoji will be Prayer,sad,love,smile
    // Route::post('alerts/{id}/like/{type}', 'AlertController@like'); //Added here

    // Alert Expression count
    // --> likes_prayer_count, likes_sad_count, likes_love_count, likes_smile_count

    // Alerts short description Api (within 2 line. It will show under the alerts image.).
    // in alerts create, there is new field called short_description, now user can add a short description too
    // && in alert details or alert list -> hort_description is available


    ///////////////////////////////////////////////////////
    Route::post('addfollow', 'FollowController@store');  
    Route::post('getfollow', 'FollowController@index');   
    Route::post('deletefollow', 'FollowController@destroy');   



});
