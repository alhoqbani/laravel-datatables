<?php

Route::get('admin/users', 'Admin\UserController@index')->name('admin.users.index');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
