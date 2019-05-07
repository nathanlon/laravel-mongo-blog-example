<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('/posts/tag/{id}', 'TagsController@indexByTag')->name('posts_index_tag');
//
//Route::get('/posts/year/{year}', 'PostsController@indexByYear');
//
//Route::get('/posts/month/{month}', 'PostsController@indexByMonth');

Route::get('/posts/page/{number}', 'PostsController@showPage')->name('post_show_page');

Route::get('/posts/{id}', 'PostsController@show')->name('post_show');

Route::get('/admin/posts/create', 'AdminPostsController@create')->name('admin_post_create');

Route::get('/admin/posts/{id}/edit', 'AdminPostsController@edit')->name('admin_post_edit');

Route::post('/admin/posts/{id}/edit', 'AdminPostsController@update')->name('admin_post_update');

Route::post('/admin/posts/{id}/delete', 'AdminPostsController@delete')->name('admin_post_delete');

Route::get('/admin/posts', 'AdminPostsController@index')->name('admin_posts_index');

Route::post('/admin/posts', 'AdminPostsController@store')->name('admin_post_store');

Route::get('/admin/tags', 'AdminTagsController@index')->name('admin_tags_index');

Route::post('/admin/tag/{id}/delete', 'AdminTagsController@delete')->name('admin_tag_delete');

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin_home');
