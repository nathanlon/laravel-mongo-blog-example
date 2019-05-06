<?php

Route::get('/', 'HomeController@index');

Route::get('/posts/tag/{tag}', 'PostsController@indexByTag');

Route::get('/posts/year/{year}', 'PostsController@indexByYear');

Route::get('/posts/month/{month}', 'PostsController@indexByMonth');

Route::get('/posts/{id}', 'PostsController@show');


Route::get('admin', 'AdminController@index');

//Route::get('admin/login', 'AdminController@login');

Route::get('admin/posts/create', 'AdminPostsController@create');

Route::post('admin/posts', 'AdminPostsController@store');

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('home');
