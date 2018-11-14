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
        if ($html = get_page_cache('tag', $url_name)) {
            return $html;
        }
        $map = [];
        $map[] = ["status", "=", Tag::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $tag = Tag::with(["user"])->withCount("articles")->where($map)->first();
        if (!$tag)
            abort(404);

        $html = view("page.tag", compact("tag"));
        set_page_cache('tag', $url_name, $html);
        return $html;
    }
}
