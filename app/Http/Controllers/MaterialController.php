<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends AdminBaseController
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
        $map = ["status" => $request->input("status", Material::STATUS_NORMAL)];
        $materials = Material::with(["user"])->where($map)->orderBy("created_at", "desc")->paginate($perPage);
        return response()->api($materials);
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
            "title" => "max:255",
            "url"   => "required|url",
        ]);

        $material = new Material;
        $material->title = $request->input("title", "default material title");
        $material->type = Material::TYPE_IMAGE;
        $material->status = Material::STATUS_NORMAL;
        $material->url = $request->input("url");
        $material->user_id = Auth::id();

        $isSaved = $material->save();
        if ($isSaved) {
            return response()->api($material, "素材创建成功!");
        } else {
            return response()->api($material, "素材创建失败!", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return response()->api($material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        // 验证数据
        $request->validate([
            "title" => "max:255",
            "url"   => "required|url",
        ]);

        $material->title = $request->input("title", "default material title");
        $material->url = $request->input("url");

        $isSaved = $material->save();
        if ($isSaved) {
            return response()->api($material, "素材修改成功!");
        } else {
            return response()->api($material, "素材修改失败!", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        if ($material->status == Material::STATUS_DELETED) {
            return response()->api($material, "该素材已经删除，请勿重复操作!");
        } else {
            $material->status = Material::STATUS_DELETED;
            $isDeleted = $material->save();
            list($emp, $path) = explode(config("filesystems.material_root_url"), $material->url);
            Storage::disk('qiniu')->delete($path);
            return response()->api($material, "删除成功!");
        }
    }

    /**
     * 上传文件到七牛云
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $request->validate([
            "file" => "required|file",
        ]);
        $path = $request->file("file")->store(
            'image/' . $request->user()->id, 'qiniu'
        );
        if (!$path) {
            return response()->api([], "文件保存失败！", 500);
        } else {
            $fullPath = config("filesystems.material_root_url") . $path;

            $material = new Material;
            $material->title = $request->file("file")->getClientOriginalName();
            $material->type = Material::TYPE_IMAGE;
            $material->status = Material::STATUS_NORMAL;
            $material->url = $fullPath;
            $material->user_id = Auth::id();

            $isSaved = $material->save();
            if (!$isSaved) {
                return response()->api($material, "素材保存失败!", 500);
            }
            return response()->api($material, "文件保存成功!");
        }
    }
}
