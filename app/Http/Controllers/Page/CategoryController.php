<?php

namespace App\Http\Controllers\Page;

use App\Category;
use App\Http\Controllers\Controller;
use App\Jobs\SetPageView;
use App\Logics\PageViewLogic;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    //
    public function index($url_name)
    {
        SetPageView::dispatch(new PageViewLogic(), $url_name, 'category');
        if ($html = get_page_cache('category', $url_name)) {
            return $html;
        }
        $map = [];
        $map[] = ["status", "=", Category::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $category = Category::with(["articles", "user"])->withCount("articles")->where($map)->first();
        if (!$category)
            abort(404);

        $html = view("page.category", compact("category"));
        set_page_cache('category', $url_name, $html);
        return $html;
    }
}
