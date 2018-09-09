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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(["middleware" => ["auth"], "prefix" => "admin"], function () {
    Route::get("/", function () {
        return view("admin");
    });
    Route::get("tags/all", "TagController@all");
    Route::resource("tags", "TagController");
    Route::put("tags/{tag}/revoke", "TagController@revoke");
    Route::get("categories/all", "CategoryController@all");
    Route::get("categories/tree", "CategoryController@tree");
    Route::resource("categories", "CategoryController");
    Route::put("categories/{category}/revoke", "CategoryController@revoke");
    Route::resource("materials", "MaterialController");
    Route::post("materials/upload", "MaterialController@upload");

    Route::resource("articles", "ArticleController");
    Route::put("articles/{article}/publish", "ArticleController@publish");
    Route::put("articles/{article}/revoke", "ArticleController@revoke");
});