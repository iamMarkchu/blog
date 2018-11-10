<?php

namespace App\Http\Controllers\Page;

use App\Article;
use App\Utils\Markdown\Markdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function index($url_name)
    {
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

        return view("page.article", compact("article","list"));
    }
}
