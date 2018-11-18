<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Repositories\TagRepository;
use App\Tag;
use App\Utils\Baidu\Translate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends AdminBaseController
{
    protected $tag;

    /**
     * TagController constructor.
     * @param $tag
     */
    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->tag->page($request->input('pageSize', 15)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'name' => $request->input('name'),
            'display_order' => $request->input('display_order'),
            'status' => Tag::STATUS_NORMAL,
            'user_id' => Auth::id(),
        ];
        if ($tag = $this->tag->create($data)) {
            return response()->api($tag, "保存成功!");
        } else {
            return response()->api($tag, "保存失败!", 500);
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
        return response()->api($this->tag->byId($id), "获取成功!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTagRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, int $id)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'name' => $request->input('name'),
            'display_order' => $request->input('display_order'),
        ];

        $tag = $this->tag->update($data, $id);
        if ($tag) {
            return response()->api($tag, "修改成功!");
        } else {
            return response()->api($tag, "修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if ($tag = $this->tag->del($id)) {
            return response()->api($tag, "删除成功!");
        } else {
            return response()->api($tag, "该标签已经删除了！请勿重复操作!");
        }
    }

    public function revoke(int $id)
    {
        if ($tag = $this->tag->rev($id)) {
            return response()->api($tag, "恢复成功!");
        } else {
            return response()->api($tag, "该标签已经恢复了！请勿重复操作!");
        }
    }

    public function all()
    {
        return response()->api(Tag::with("user")->where("status", "=", "1")->orderBy("created_at", "desc")->get());
    }
}
