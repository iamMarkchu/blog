<?php

namespace App\Http\Controllers\Page;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    //
    public function index($url_name)
    {
        $map = [];
        $map[] = ["status", "=", Tag::STATUS_NORMAL];
        $map[] = ["url_name", "=", $url_name];
        $tag = Tag::with(["user"])->withCount("articles")->where($map)->first();
        if (!$tag)
            abort(404);

        return view("page.tag", compact("tag"));
    }
}
