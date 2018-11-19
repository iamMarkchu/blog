<?php

namespace App\Http\Controllers;

use App\Logics\PageViewLogic;
use Illuminate\Http\Request;

class PageCountController extends Controller
{
    /**
     * @param string $type
     * @param int $id
     * @return string
     */
    public function viewCount(string $type, int $id)
    {
        return response()->api((new PageViewLogic())->getViewCount($id, $type), '页面浏览量');
    }
}
