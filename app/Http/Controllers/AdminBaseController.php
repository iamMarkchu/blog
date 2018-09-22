<?php

namespace App\Http\Controllers;

class AdminBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "checkLevel"]);
    }
}
