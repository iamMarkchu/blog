<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YoudaoController extends AdminBaseController
{

    public function index(Request $request)
    {
        return view("youdao");
    }
}
