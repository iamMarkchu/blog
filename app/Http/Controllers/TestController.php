<?php

namespace App\Http\Controllers;

use App\Utils\Github\Api\Tree;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index()
    {
        $tree = new Tree();
        $response = $tree->setOwner("iamMarkchu")->setRepos("blog_articles")->setTreeSha("master")->getTree();
        dd($response);
    }
}
