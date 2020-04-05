<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('users/personalpermissions/{id}', 'UserController@personalPermissions')->name('users.personalpermissions');
Route::put('users/syncpermissions/{id}', 'UserController@syncPermissions')->name('users.syncpermissions');
Route::get('users/changemcstate/{id}/{list}/{state}', ['as' => 'users.changemcstate', 'uses' => 'UserController@changeMCState']);
Route::get('users/changestate/{id}/{state}', ['as' => 'users.changestate', 'uses' => 'UserController@changeState']);
Route::get('users/profile', ['as' => 'users.profile', 'uses' => 'UserController@editProfile']);
Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');
