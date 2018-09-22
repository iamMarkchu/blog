<?php

namespace App\Http\Controllers;

class AdminController extends AdminBaseController
{
    //
    public function index()
    {
        return view("admin");
    }
}
