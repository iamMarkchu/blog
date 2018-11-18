<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/18
 * Time: 17:44
 */

namespace App\Repositories;


use App\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository
{

    private $error;



    public function page($pageSize)
    {
        return Category::with(["parentCategory", "user"])->orderBy("created_at", "desc")->paginate($pageSize);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function byId(int $id)
    {
        return Category::find($id);
    }

    public function update(array $data, int $id)
    {
        $category = Category::find($id);
        if (!$category)
            return false;
        $isSaved = $category->fill($data)->save();
        if ($isSaved) {
            // 清除缓存
            $cacheKey = config('cachekey.cache_categories_page').md5($category->url_name);
            clear_page_cache($cacheKey);
            return $category;
        }
        return false;
    }

    public function del(int $id)
    {
        return $this->changeStatus(Category::find($id), Category::STATUS_DELETED);
    }

    public function rev(int $id)
    {
        return $this->changeStatus(Category::find($id), Category::STATUS_NORMAL);
    }

    private function changeStatus(Category $category, int $operation) {
        if ($category->user_id != Auth::id()) {
            $this->error = '您不是该文章的作者，无权操作!';
            return false;
        }

        if ($category->status == $operation) {
            $this->error = '请勿重复操作!';
            return false;
        }

        $category->status = $operation;
        $category->save();
        return $category;
    }

    public function all()
    {
        return Category::with(["parentCategory", "user"])->orderBy("created_at", "desc")->get();
    }

    public function tree()
    {
        return cascader_item(Category::with(["parentCategory", "user"])->orderBy("created_at", "desc")->get()->toArray());
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}