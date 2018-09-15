<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = [];
        $perPage = $request->input("per_page", 15);
        $status = $request->input("status", -1);
        $source = $request->input("source", 0);
        $title = $request->input("title", "");
        if ($status != Article::STATUS_ALL && !empty($status)) {
            $map[] = ["status", "=", $status];
        }
        if ($source) {
            $map[] = ["source", "=", $source];
        }
        if (!empty($title))
        {
            $map[] = ["title", "like", "%$title%"];
        }


        $articles = Article::with(["user", "categories", "tags"])->where($map)->orderBy("created_at", "desc")->paginate($perPage);

        return response()->api($articles);
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
            "title"         => "required|unique:articles|max:255",
            "content"       => "required",
            "cover"         => "url|nullable",
            "display_order" => "integer|nullable",
            "source"        => Rule::in([1, 2]),
            "categories"    => "array|nullable",
            "tags"          => "array|nullable",
        ]);
        $article = new Article;

        $article->title = $request->input("title");
        $article->url_name = generate_url($article->title);
        $article->content = $request->input("content");
        if ($request->filled("cover")) {
            $article->cover = $request->input("cover");
        }
        if ($request->filled("display_order")) {
            $article->display_order = $request->input("display_order");
        }
        $article->source = $request->input("source");
        $article->status = Article::STATUS_PENDING;
        $article->user_id = Auth::id();

        $isSaved = $article->save();
        if ($isSaved) {
            if ($request->filled("categories") and !empty($request->input("categories"))) {
                $article->categories()->sync($request->input("categories"));
            }
            if ($request->filled("tags") and !empty($request->input("tags"))) {
                $article->tags()->sync($request->input("tags"));
            }

            return response()->api($article, "文章保存成功!");
        } else {
            return response()->api($article, "文章保存失败!", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $article->categories;
        $article->tags;

        return response()->api($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        // 验证数据
        $request->validate([
            "title"         => "required|max:255|unique:articles,title," . $article->id,
            "content"       => "required",
            "cover"         => "url|nullable",
            "display_order" => "integer|nullable",
            "source"        => Rule::in([1, 2]),
            "categories"    => "array|nullable",
            "tags"          => "array|nullable",
        ]);

        $isNameChanged = !($article->title == $request->title);
        if ($isNameChanged) {
            $article->title = $request->title;
            $article->url_name = generate_url($request->title);
        }
        $article->content = $request->input("content");
        if ($request->filled("cover")) {
            $article->cover = $request->input("cover");
        }
        if ($request->filled("display_order")) {
            $article->display_order = $request->input("display_order");
        }
        $article->source = $request->input("source");
        $isSaved = $article->save();
        if ($isSaved) {
            if ($request->filled("categories")) {
                $article->categories()->sync($request->input("categories"));
            }
            if ($request->filled("tags") and !empty($request->input("tags"))) {
                $article->tags()->sync($request->input("tags"));
            }

            return response()->api($article, "文章修改成功!");
        } else {
            return response()->api($article, "文章修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if ($article->user_id != Auth::id()) {
            return response()->api([], "你无权删除此文章!", 500);
        }

        if ($article->status != Article::STATUS_DELETED) {
            $article->status = Article::STATUS_DELETED;
            $isDeleted = $article->save();

            return response()->api($article, "删除成功!");
        } else {
            return response()->api($article, "该文章已经删除了！请勿重复操作!");
        }
    }

    public function publish(Article $article)
    {
        if ($article->user_id != Auth::id()) {
            return response()->api([], "你无权发布此文章!", 500);
        }

        if ($article->status != Article::STATUS_NORMAL) {
            $article->status = Article::STATUS_NORMAL;
            $isPublished = $article->save();
            return response()->api($article, "发布成功!");
        } else {
            return response()->api($article, "该文章已经发布了，请勿重复操作");
        }
    }

    public function revoke(Article $article)
    {
        if ($article->user_id != Auth::id()) {
            return response()->api([], "你无权撤销此文章!", 500);
        }

        if ($article->status == Article::STATUS_DELETED) {
            $article->status = Article::STATUS_NORMAL;
            $isPublished = $article->save();
            return response()->api($article, "撤销成功!");
        } else {
            return response()->api($article, "该文章已经撤销了，请勿重复操作");
        }
    }
}
