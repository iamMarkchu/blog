<?php

namespace App\Http\Controllers;

use App\Utils\Github\Api\Tree;
use Illuminate\Http\Request;

class GithubController extends AdminBaseController
{
    //
    public function index()
    {
        $tree = new Tree();
        $owner = config("github.owner");
        $repos = config("github.repos");
        $treeSha = config("github.tree_sha");
        $response = $tree->setOwner($owner)->setRepos($repos)->setTreeSha($treeSha)->getTree();
        return response()->api($response);
    }
}
