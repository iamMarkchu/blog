<?php

namespace App\Http\Controllers\Page;

use App\Article;
use App\Utils\Markdown\Markdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    //
    public function index($url_name)
    {
        // 缓存页面的key
        $cacheKey = config('cachekey.cache_articles_page').md5($url_name);
        if ($html = Redis::get($cacheKey)) {
            return $html;
        }
        $article = Article::with(["categories", "tags", "user"])->where(["status" => Article::STATUS_NORMAL, "url_name" => $url_name])->first();
        if (!$article)
            abort(404);

        // markdown to html
        $article->markdown = (new Markdown())->parse($article->content);
        // generate list
        // 截取每行 2-6个字符,
        $contentList = explode("\n", $article->content);

        // 目录
        $list = [];
        foreach ($contentList as $l) {
            // 空行直接过滤掉
            if (empty($l))
                continue;
            // 仅匹配 h2和h3
            for ($i = 2; $i <= 3; $i++) {
                $tmp = [];
                $search = substr($l, 0, $i + 1);
                $standardStr = str_repeat("#", $i) . " ";
                if ($search == $standardStr) {
                    $tmp["name"] = str_replace($standardStr, "", $l);
                    if ($i == 2) {
                        $list[] = $tmp;
                    } else {
                        $list[count($list)-1]["child"][] = $tmp;
                    }
                }
            }
        }

        $html = view("page.article", compact("article","list"));
        // 缓存页面
        Redis::set($cacheKey, $html);

        return $html;
    }
}
