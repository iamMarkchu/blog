<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/19
 * Time: 21:47
 */

namespace App\Logics;


use App\Article;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Redis;

class PageViewLogic
{
    public function setViewCount($url_name, $type)
    {
        switch ($type) {
            case 'article':
                $page = Article::where('url_name', $url_name)->where('status', 1)->first();
                break;
            case 'category':
                $page = Category::where('url_name', $url_name)->where('status', 1)->first();
                break;
            case 'tag':
                $page = Tag::where('url_name', $url_name)->where('status', 1)->first();
                break;
            default:
                return false;
        }
        if ($page) {
            $cacheKey = config('cachekey.cache_view_count'). $type. ":".$page->id;
            return Redis::incr($cacheKey);
        }

        return false;
    }

    public function getViewCount($id, $type)
    {
        return Redis::get(config('cachekey.cache_view_count'). $type. ":".$id) ??0;
    }
}