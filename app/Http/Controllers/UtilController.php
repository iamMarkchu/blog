<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    //
    public function generateUrl(Request $request)
    {
        $this->validate($request, [
            'q' => 'required|min:2|max:255'
        ]);

        return response()->api(generate_url($request->q), '生成成功!');
    }
}
