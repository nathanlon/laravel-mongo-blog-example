<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('/posts/tag/{tag}', 'PostsController@indexByTag');

Route::get('/posts/year/{year}', 'PostsController@indexByYear');

Route::get('/posts/month/{month}', 'PostsController@indexByMonth');

Route::get('/posts/{id}', 'PostsController@show');

Route::get('/admin/posts/create', 'AdminPostsController@create');

Route::get('/admin/posts/{id}/edit', 'AdminPostsController@edit')->name('admin_post_edit');

Route::post('/admin/posts/{id}/edit', 'AdminPostsController@update')->name('admin_post_update');

Route::post('/admin/posts/{id}/delete', 'AdminPostsController@delete')->name('admin_post_delete');

Route::get('/admin/posts', 'AdminPostsController@index')->name('admin_posts');

Route::post('/admin/posts', 'AdminPostsController@store');

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin_home');
