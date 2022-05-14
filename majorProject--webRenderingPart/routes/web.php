<?php

use Illuminate\Http\Request;

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

Route::get('register', function(){
	return view('users.register');
});

Route::post('register', function(Request $request){
	$request->validate([
		'name' => 'required',
		'email'=> 'required|email',
		'password'=>'required',
		'password_confirmation'=>'required',
	]);

	\App\Admin::create([
		'name' => request('name'),
		'email'=> request('email'),
		'password'=> bcrypt(request('password')),
	]);

	return redirect('admin');
});

Route::prefix('/admin')->group(function(){
	Route::get('login', 'Auth\AdminLoginController@showLoginForm');
	Route::post('login', 'Auth\AdminLoginController@login')->name('login');
	Route::get('logout', 'Auth\AdminLoginController@logout')->name('logout');

	Route::get('added-suspects', 'AdminController@getAddedSuspects');

	Route::get('detected-suspects', 'AdminController@showDetectedSuspects');
	Route::post('detected-suspects/{suspect}', 'AdminController@addDetectedSuspectToUserProfile');

	Route::get('add-suspect', 'AdminController@showAddSuspectForm');

	Route::post('add-suspect', 'AdminController@addSuspect');

	Route::post('add-embedding', 'AdminController@addEmbedding');

	Route::delete('suspects/{suspect}/delete', 'AdminController@deleteSuspect');


	// Password resetting routes
	Route::get('forgot-password', 'Auth\AdminForgotPasswordController@showLinkRequestForm');
	Route::post('forgot-password', 'Auth\AdminForgotPasswordController@sendResetLinkEmail');
	Route::get('reset-password/{token}', 'Auth\AdminResetPasswordController@showResetForm');
	Route::post('reset-password', 'Auth\AdminResetPasswordController@reset');

	// Profile modification routes
	Route::get('change-pw', 'AdminController@changePW');
	Route::post('change-pw', 'AdminController@updatePW');
	Route::get('edit-profile', 'AdminController@editProfile');
	Route::patch('edit-profile', 'AdminController@updateProfile');

	Route::get('/', 'AdminController@showDashboard');
});
