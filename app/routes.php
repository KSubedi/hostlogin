<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Handle Homepage
Route::any('/', array('as' => 'home', 'uses' => 'PageController@showHome'));

//Handle Login
Route::group(array('prefix' => 'login'), function(){
	//Handle Login Page
	Route::any('form', array('as' => 'login', 'uses' => 'LoginController@showLogin'));

	//Handle Register Page
	Route::any('form/register', array('as' => 'register', 'uses' => 'LoginController@showRegister'));
});

//Handle Static Pages
Route::any('pages/{page}',array('as' => 'page','uses' => 'PageController@showPage'));

//Handle Image Requests (All Images Need To Be PNG's)
Route::any('images/{image}.png', array('as' => 'images', 'uses' => 'PageController@showImage'));

//Handle asset files
Route::any('assets/{asset}', array('as' => 'assets', 'uses' => 'PageController@showAsset'));

/* App Routes From Here On */

Route::post('core/submit',array('as' => 'submit', 'uses' => 'LoginController@submitForm'));

Route::any('logout', array('as' => 'logout', 'uses' => 'LoginController@logoutUser'));

Route::group(array('prefix' => 'password'), function(){
	Route::any('forgot', array('as' => 'forgotpassword', 'uses' => 'RemindersController@getRemind'));
	Route::any('submit', array('as' => 'remind', 'uses' => 'RemindersController@postRemind'));
	Route::any('reset/{token}', array('as' => 'reset', 'uses' => 'RemindersController@getReset'));
	Route::any('reset', array('as' => 'postreset', 'uses' => 'RemindersController@postReset'));
});

Route::any('confirm/{token}', array('as' => 'confirm', 'uses' => 'LoginController@confirmEmail'));

Route::group(array('before' => 'auth', 'prefix' => 'panel'), function() {
	
	Route::any('dashboard', array('as' => 'dashboard', 'uses' => 'DashBoardController@showDashBoard'));

	Route::any('addserver', array('as' => 'addserver', 'uses' => 'DashBoardController@addServer'));

	Route::any('editserver/{server}', array('as' => 'editserver', 'uses' => 'DashBoardController@editServer'));

	Route::any('editserver', array('as' => 'editserverreal', 'uses' => 'DashBoardController@editServerReal'));

	Route::any('preferences', array('as' => 'preferences', 'uses' => 'DashBoardController@showPreferences'));

	Route::group(array('before' => 'csrf'), function() {

		Route::post('addserver/submit', array('as' => 'addserversubmit', 'uses' => 'DashBoardController@addServerSubmit'));

		Route::post('preferences/submit', array('as' => 'preferencessubmit', 'uses' => 'DashBoardController@preferencesSubmit'));

		Route::post('deleteserver', array('as' => 'deleteserversubmit', 'uses' => 'DashBoardController@deleteServerSubmit'));
	});
});