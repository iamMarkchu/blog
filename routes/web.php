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

Route::get("/admin", "AdminController@index");
Route::get("/admin/tags/all", "TagController@all");
Route::resource("/admin/tags", "TagController");
Route::put("/admin/tags/{tag}/revoke", "TagController@revoke");
Route::get("/admin/categories/all", "CategoryController@all");
Route::get("/admin/categories/tree", "CategoryController@tree");
Route::resource("/admin/categories", "CategoryController");
Route::put("/admin/categories/{category}/revoke", "CategoryController@revoke");
Route::resource("/admin/materials", "MaterialController");
Route::post("/admin/materials/upload", "MaterialController@upload");
Route::resource("/admin/articles", "ArticleController");
Route::put("/admin/articles/{article}/publish", "ArticleController@publish");
Route::put("/admin/articles/{article}/revoke", "ArticleController@revoke");

Route::resource("/admin/github", "GithubController");

// 博客页面

Route::get("/", "Page\HomeController@index")->name("home");  // 首页
Route::get("/articles/{url_name}", "Page\ArticleController@index")->name("article");  // 文章页面
Route::get("/tags/{url_name}", "Page\TagController@index")->name("tag");  // 标签页面
Route::get("/categories/{url_name}", "Page\CategoryController@index")->name("category");  // 类别页面