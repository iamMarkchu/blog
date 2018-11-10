<?php

namespace App\Http\Controllers\Page;

use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TagController extends Controller
{
    //
    public function index($url_name)
    {
        // 缓存页面的key
        $cacheKey = config('cachekey.cache_tags_page').md5($url_name);
        if ($html = Redis::get($cacheKey)) {
            return $html;
        }
        $map = [];
        $map[] = ["status", "=", Tag::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $tag = Tag::with(["user"])->withCount("articles")->where($map)->first();
        if (!$tag)
            abort(404);

        $html = view("page.tag", compact("tag"));
        Redis::set($cacheKey, $html);
        return $html;
    }
}
