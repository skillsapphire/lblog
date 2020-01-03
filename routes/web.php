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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::resource('posts', 'PostsController');

// REST API example
/*Route::get('/hello', function () {
    return 'Hello world!';
});

Route::get('/about', function () {
    return view('pages.about');
});*/
// Dynamic route example
/*Route::get('/users/{id}/{name}', function ($id, $name) {
    return 'This is user '.$id.' with name '.$name;
});*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
