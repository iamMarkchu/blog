<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input("per_page", 15);
        $categories = Category::with("parentCategory")->orderBy("created_at", "desc")->paginate($perPage);
        return response()->api($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证数据
        $request->validate([
            "name" => "required|unique:categories|max:255",
            "display_order" => "integer",
            "parent_id" => "integer",
        ]);

        // 组装数据
        $category = new Category;
        $category->name = $request->name;
        if ($request->has("display_order"))
        {
            $category->display_order = $request->display_order;
        }

        if ($request->has("parent_id"))
        {
            $category->parent_id = $request->parent_id;
        }

        $category->url_name = generate_url($request->name);
        $category->status = Category::STATUS_NORMAL;
        $category->user_id = Auth::id();
        $isSaved = $category->save();

        if ($isSaved) {
            return response()->api($category, "保存成功!");
        } else {
            return response()->api($category, "保存失败!", 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->api($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // 验证数据
        $request->validate([
            "name" => "required|max:255|unique:categories,name," . $category->id,
            "display_order" => "integer",
            "parent_id" => "integer",
        ]);

        $isNameChanged = !($category->name == $request->name);
        if ($isNameChanged) {
            $category->name = $request->name;
            $category->url_name = generate_url($request->name);
        }
        if ($request->has("display_order")) {
            $category->display_order = $request->display_order;
        }
        $isSaved = $category->save();
        if ($isSaved) {
            return response()->api($category, "修改成功!");
        } else {
            return response()->api($category, "修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->status != Category::STATUS_DELETED) {
            $category->status = Category::STATUS_DELETED;
            $isDeleted = $category->save();
            return response()->api($category, "删除成功!");
        } else {
            return response()->api($category, "该类别已经删除了！请勿重复操作!");
        }
    }
}
