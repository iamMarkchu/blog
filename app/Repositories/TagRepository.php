<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/18
 * Time: 18:16
 */

namespace App\Repositories;


use App\Tag;
use Illuminate\Support\Facades\Auth;

class TagRepository
{
    private $error;

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function page($pageSize)
    {
        return Tag::with(["user"])->orderBy("created_at", "desc")->paginate($pageSize);
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function byId(int $id)
    {
        return Tag::find($id);
    }

    public function update(array $data, int $id)
    {
        $tag = Tag::find($id);
        if(!$tag)
            return false;
        if ($tag->fill($data)->save()) {
            // 清除缓存
            $cacheKey = config('cachekey.cache_tags_page').md5($tag->url_name);
            clear_page_cache($cacheKey);
            return $tag;
        }
        return false;
    }

    public function del(int $id)
    {
        return $this->changeStatus(Tag::find($id), Tag::STATUS_DELETED);
    }

    public function rev(int $id)
    {
        return $this->changeStatus(Tag::find($id), Tag::STATUS_NORMAL);
    }

    private function changeStatus(Tag $tag, int $operation) {
        if ($tag->user_id != Auth::id()) {
            $this->error = '您不是该文章的作者，无权操作!';
            return false;
        }

        if ($tag->status == $operation) {
            $this->error = '请勿重复操作!';
            return false;
        }

        $tag->status = $operation;
        $tag->save();
        return $tag;
    }
}