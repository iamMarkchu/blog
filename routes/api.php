<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::Group(['middleware' => ['auth:api']], function () {

    // TAG
    Route::get("tags/all", "TagController@all");
    Route::put("tags/{tag}/revoke", "TagController@revoke");
    Route::resource("tags", "TagController");

    // CATEGORY
    Route::get("categories/all", "CategoryController@all");
    Route::get("categories/tree", "CategoryController@tree");
    Route::resource("categories", "CategoryController");
    Route::put("categories/{category}/revoke", "CategoryController@revoke");

    // MATERIAL
    Route::post("materials/upload", "MaterialController@upload");
    Route::resource("materials", "MaterialController");

    // ARTICLE
    Route::resource("articles", "ArticleController");
    Route::put("articles/{article}/publish", "ArticleController@publish");
    Route::put("articles/{article}/revoke", "ArticleController@revoke");

    // GITHUB
    Route::resource("github", "GithubController");

    // UPLOAD
    \LaravelUploader::routes();

    // GENERATE URL
    Route::get('generate-url', 'UtilController@generateUrl');
});