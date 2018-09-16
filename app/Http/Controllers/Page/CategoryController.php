<?php

namespace App\Http\Controllers\Page;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function index($url_name)
    {
        $map = [];
        $map[] = ["status", "=", Category::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $category = Category::with(["articles", "user"])->withCount("articles")->where($map)->first();
        if (!$category)
            abort(404);

        return view("page.category", compact("category"));
    }
}
