<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends AdminBaseController
{

    protected $category;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->api($this->category->page($request->input('pageSize', 15)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'name' => $request->input('name'),
            'recursive' => implode(',', $request->input('recursive')),
            'parent_id' => $request->input('parent_id', 0),
            'display_order' => $request->input('display_order'),
            'status' => Category::STATUS_NORMAL,
            'user_id' => Auth::id(),
        ];
        $category = $this->category->create($data);

        if ($category) {
            return response()->api($category, "保存成功!");
        } else {
            return response()->api($category, "保存失败!", 500);
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
        return response()->api($this->category->byId($id), "获取成功!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $data = [
            'url_name' => $request->input('url_name'),
            'name' => $request->input('name'),
            'recursive' => implode(',', $request->input('recursive')),
            'parent_id' => $request->input('parent_id', 0),
            'display_order' => $request->input('display_order'),
        ];
        $category = $this->category->update($data, $id);
        if ($category) {
            return response()->api($category, "修改成功!");
        } else {
            return response()->api($category, "修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if ($category = $this->category->del($id)) {
            return response()->api($category, "删除成功!");
        } else {
            return response()->api([], $this->category->getError());
        }
    }

    public function revoke(int $id)
    {
        if ($category = $this->category->rev($id)) {
            return response()->api($category, "恢复成功!");
        } else {
            return response()->api([], $this->category->getError());
        }
    }

    public function all()
    {
        return response()->api($this->category->all());
    }

    public function tree()
    {
        return response()->api($this->category->tree());
    }
}
