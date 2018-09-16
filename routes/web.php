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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/youdao', "YoudaoController@index");
Route::get('/test', "TestController@index");

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

    Route::resource("github", "GithubController");
});

// 博客页面
Route::group(["namespace" => "Page"], function () {
    Route::get("/", "HomeController@index")->name("home");  // 首页
    Route::get("/articles/{url_name}", "ArticleController@index")->name("article");  // 文章页面
    Route::get("/tags/{url_name}", "TagController@index")->name("tag");  // 标签页面
    Route::get("/categories/{url_name}", "CategoryController@index")->name("category");  // 类别页面
});