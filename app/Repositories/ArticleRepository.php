<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/17
 * Time: 0:57
 */

namespace App\Repositories;


use App\Article;
use Illuminate\Support\Facades\Auth;

class ArticleRepository
{
    private $error;

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function page($filter, $pageSize)
    {
        return Article::with(["user", "categories", "tags"])->filter($filter)->orderBy("created_at", "desc")->paginate($pageSize);
    }

    /**
     * @param array $data
     * @return bool| \App\Article
     */
    public function create(array $data)
    {
        $article = Article::create($data);
        if ($article) {
            $article->categories()->sync($data['categories']);
            $article->tags()->sync($data['tags']);
            return $article;
        }
        return false;
    }

    public function update($data, $id)
    {
        $article = Article::find($id);
        if (!$article)
            return false;
        $article->fill($data)->save();
        if ($article) {
            $article->categories()->sync($data['categories']);
            $article->tags()->sync($data['tags']);

            // 清除缓存
            $cacheKey = config('cachekey.cache_articles_page').md5($article->url_name);
            clear_page_cache($cacheKey);
            return $article;
        }
        return false;
    }

    public function byIdWithCategoriesAndTags($id)
    {
        return Article::with(['categories', 'tags'])->find($id);
    }

    public function del($id)
    {
        return $this->changeStatus(Article::find($id), Article::STATUS_DELETED);
    }

    public function pub($id)
    {
        return $this->changeStatus(Article::find($id), Article::STATUS_NORMAL);
    }

    public function rev($id)
    {
        return $this->changeStatus(Article::find($id), Article::STATUS_PENDING);
    }

    private function changeStatus(Article $article, int $operation) {
        if ($article->user_id != Auth::id()) {
            $this->error = '您不是该文章的作者，无权操作!';
            return false;
        }

        if ($article->status == $operation) {
            $this->error = '请勿重复操作!';
            return false;
        }

        $article->status = $operation;
        $article->save();
        return $article;
    }
}