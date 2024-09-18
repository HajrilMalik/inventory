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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('stokBarangs', 'Backend\StokBarangsController', ['names' => 'admin.stokBarangs']);
    Route::resource('barangKeluars', 'Backend\BarangKeluarController', ['names' => 'admin.barangKeluars']);
    Route::resource('barangMasuks', 'Backend\BarangMasukController', ['names' => 'admin.barangMasuks']);
    Route::get('admin/statusPendaftarans/exportExcel', 'Backend\StatusPendaftaranController@exportExcel')->name('admin.statusPendaftarans.exportExcel');
    Route::get('/admin/barangKeluars/export', 'App\Http\Controllers\Backend\BarangKeluarController@export')->name('admin.barangKeluars.export');
    Route::get('/admin/stokBarangs/export', 'App\Http\Controllers\Backend\StokBarangsController@export')->name('admin.stokBarangs.export');

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});