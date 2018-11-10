<?php

namespace App\Http\Controllers\Page;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    //
    public function index($url_name)
    {
        // 缓存页面的key
        $cacheKey = config("cachekey.cache_categories_page").md5($url_name);
        if ($html = Redis::get($cacheKey)) {
            return $html;
        }
        $map = [];
        $map[] = ["status", "=", Category::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $category = Category::with(["articles", "user"])->withCount("articles")->where($map)->first();
        if (!$category)
            abort(404);

        $html = view("page.category", compact("category"));
        Redis::set($cacheKey, $html);
        return $html;
    }
}
