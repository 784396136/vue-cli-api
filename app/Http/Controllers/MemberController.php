<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Member;

class MemberController extends Controller
{
    //
    public function insert(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'username'=>'required|min:6|max:18|unique:members',
            'password'=>'required|min:6|max:18|confirmed',
        ]);

        // 失败
        if($validator->fails())
        {
            // 保存错误信息
            $errors = $validator->errors();
            // 返回JSON数据和422状态码
            return error($errors,422);
        }

        // 将数据插入数据库
        $member = Member::create([
            'username' => $req->username,
            'password' => bcrypt($req->password)
        ]);
        return ok($member);
    }
}
