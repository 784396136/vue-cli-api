<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    // 测试
    public function test(Request $req)
    {
        $data = $req->all();

        dd($data);
    }
}