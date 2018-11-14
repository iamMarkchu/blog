<?php

namespace App\Http\Controllers\Page;

use App\Article;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    //
    public function index()
    {
        if ($html = get_page_cache('home')) {
            return $html;
        }
        $map = [];
        $map[] = ["status", "=", Article::STATUS_NORMAL];
        $perPage = 15;
        $articles = Article::with(["user", "categories", "tags"])->where($map)->orderBy("created_at", "desc")->paginate($perPage);

        $map = [];
        $map[] = ["status", "=", Tag::STATUS_NORMAL];
        $tags = Tag::where($map)->orderBy("display_order", "asc")->limit(12)->get();

        $map = [];
        $map[] = ["status", "=", Category::STATUS_NORMAL];
        $map[] = ["parent_id", "=", 0];
        $categories = Category::where($map)->orderBy("display_order", "asc")->limit(9)->get();
        $html = view("page.home", compact("articles", "tags", "categories"));
        set_page_cache('home', '', $html);
        return $html;
    }
}
