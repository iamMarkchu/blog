<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends AdminBaseController
{
    protected $article;

    /**
     * ArticleController constructor.
     * @param $article
     */
    public function __construct(ArticleRepository $article)
    {
        parent::__construct();
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->article->page($request->all(), $request->input('pageSize', 15)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover'),
            'display_order' => $request->input('display_order'),
            'source' => $request->input('source'),
            'status ' => Article::STATUS_NORMAL,
            'user_id' => Auth::id(),
            'categories' => $request->input('categories'),
            'tags' => $request->input('tags'),
        ];

        $article = $this->article->create($data);
        if ($article) {
            return response()->api($article, "文章保存成功!");
        } else {
            return response()->api([], "文章保存失败!", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->api($this->article->byIdWithCategoriesAndTags($id), "获取成功!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, int $id)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover'),
            'display_order' => $request->input('display_order'),
            'source' => $request->input('source'),
            'categories' => $request->input('categories'),
            'tags' => $request->input('tags'),
        ];
        $article = $this->article->update($data, $id);
        return response()->api($article, "文章修改成功!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $article = $this->article->del($id);
        if ($article) {
            return response()->api($article, "删除成功!");
        } else {
            return response()->api([], $this->article->getError(), 500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function publish(int $id)
    {
        $article = $this->article->pub($id);
        if ($article) {
            return response()->api($article, "发布成功!");
        } else {
            return response()->api([], $this->article->getError(), 500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function revoke(int $id)
    {
        $article = $this->article->rev($id);
        if ($article) {
            return response()->api($article, "撤销成功!");
        } else {
            return response()->api([], $this->article->getError(), 500);
        }
    }
}
