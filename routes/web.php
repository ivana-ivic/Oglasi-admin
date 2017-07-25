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
  if(session()->has('username')){
    return redirect()->route('home');
  }
  return view('welcome');
})->name('/');

Route::get('/login', function () {
  if(session()->has('username')){
    return redirect()->route('home');
  }
  return view('auth.login');
});
Route::get('/404', function () {
    return view('404');
})->name('404');

Route::get('/new_user', function () {
    return view('new_user');
})->name('new_user');


Route::post('/login', 'CustomAuth\UserLogin@login')->name('login');
Route::post('/logout', 'CustomAuth\UserLogin@logout')->name('logout');
Route::get('/home', 'HomeController@getReportedAds')->name('home')->middleware('CheckUserLoggedIn');
Route::get('/ads', 'AdsController@getAds')->name('ads')->middleware('CheckUserLoggedIn');
Route::get('/ad/{id}', 'AdController@getAd')->name('ad')->middleware('CheckUserLoggedIn');
Route::get('/edit_ad/{edit_id}', 'AdController@editAdPrepare')->name('edit_ad_prepare')->middleware('CheckUserLoggedIn');
Route::get('/user/{id}', 'UserController@getUser')->name('user')->middleware('CheckUserLoggedIn');
Route::get('/users', 'UsersController@getUsers')->name('users')->middleware('CheckUserLoggedIn');
Route::get('/delete_ad/{id}', 'AdController@deleteAd')->name('delete_ad')->middleware('CheckUserLoggedIn');
Route::get('/approve/{delete_id}', 'AdController@approveAd')->name('approve_ad')->middleware('CheckUserLoggedIn');
Route::get('/delete_user/{user_id}', 'UserController@deleteUser')->name('delete_user')->middleware('CheckUserLoggedIn');
Route::get('/edit_user/{user_id}', 'UserController@editUserPrepare')->name('edit_user_prepare')->middleware('CheckUserLoggedIn');
Route::post('/edit_user', 'UserController@editUser')->name('edit_user')->middleware('CheckUserLoggedIn');
Route::get('/new_ad', 'AdController@newAdPrepare')->name('new_ad_prepare')->middleware('CheckUserLoggedIn');
Route::post('/new_ad', 'AdController@newAd')->name('new_ad')->middleware('CheckUserLoggedIn');
Route::post('/edit_ad', 'AdController@editAd')->name('edit_ad')->middleware('CheckUserLoggedIn');
Route::post('/create_new_user', 'UserController@newUser')->name('create_new_user')->middleware('CheckUserLoggedIn');
