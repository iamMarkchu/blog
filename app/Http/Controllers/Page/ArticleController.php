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
        $article->markdown = (new Markdown())->parse($article->content);
        return view("page.article", compact("article"));
    }
}
