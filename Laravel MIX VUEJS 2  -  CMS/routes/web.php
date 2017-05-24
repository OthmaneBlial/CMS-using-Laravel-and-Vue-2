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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/isloggedin', function () {
    return response()->json(Auth::check());
});

Route::get('/loggingout', function () {
    return response()->json(Auth::logout());
});

Route::get('/user', function () {
    return response()->json(Auth::user());
});

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::post('/tags', 'TagController@store');
Route::get('/tags', 'TagController@index');
Route::get('/tags/{tag}', 'TagController@destroy');
Route::post('/tags/{tag}', 'TagController@update');

Route::post('/posts', 'PostController@store');
Route::get('/posts', 'PostController@index');
Route::get('/posts/show/{post}', 'PostController@show');

Route::get('/posts/{post}', 'PostController@destroy');
Route::post('/posts/{post}', 'PostController@update');

Route::get('/post_tags/{post}', 'PostController@tags');


Route::post('/comments', 'PostController@storeComment');



Route::post('/categories', 'CategoryController@store');
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{category}', 'CategoryController@destroy');
Route::post('/categories/{category}', 'CategoryController@update');


Route::post('/users', 'UserController@store');
Route::get('/users', 'UserController@index');
Route::get('/users/{user}', 'UserController@destroy');
Route::post('/users/{user}', 'UserController@update');
