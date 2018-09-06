<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Utils\Baidu\Translate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
        $tags = Tag::with(["user"])->orderBy("created_at", "desc")->paginate($perPage);
        return response()->api($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证数据
        $request->validate([
            "name" => "required|unique:tags|max:255",
            "display_order" => "integer",
        ]);

        // 组装数据
        $tag = new Tag;
        $tag->name = $request->name;
        if ($request->has("display_order"))
            $tag->display_order = $request->display_order;
        $tag->url_name = generate_url($request->name);
        $tag->status = Tag::STATUS_NORMAL;
        $tag->user_id = Auth::id();
        $isSaved = $tag->save();

        if ($isSaved) {
            return response()->api($tag, "保存成功!");
        } else {
            return response()->api($tag, "保存失败!", 500);
        }
    }

    /**
     * how the form for editing the specified resource.
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return response()->api($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // 验证数据
        $request->validate([
            "name" => "required|max:255|unique:tags,name," . $tag->id,
            "display_order" => "integer",
        ]);

        $isNameChanged = !($tag->name == $request->name);
        if ($isNameChanged) {
            $tag->name = $request->name;
            $tag->url_name = generate_url($request->name);
        }
        if ($request->has("display_order")) {
            $tag->display_order = $request->display_order;
        }
        $isSaved = $tag->save();
        if ($isSaved) {
            return response()->api($tag, "修改成功!");
        } else {
            return response()->api($tag, "修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if ($tag->status != Tag::STATUS_DELETED) {
            $tag->status = Tag::STATUS_DELETED;
            $isDeleted = $tag->save();
            return response()->api($tag, "删除成功!");
        } else {
            return response()->api($tag, "该标签已经删除了！请勿重复操作!");
        }
    }

    public function revoke(Tag $tag)
    {
        if ($tag->user_id != Auth::id()) {
            return response()->api([], "你无权撤销此文章!", 500);
        }

        if ($tag->status == Tag::STATUS_DELETED) {
            $tag->status = Tag::STATUS_NORMAL;
            $isPublished = $tag->save();
            return response()->api($tag, "撤销成功!");
        } else {
            return response()->api($tag, "该文章标签撤销了，请勿重复操作");
        }
    }
}
