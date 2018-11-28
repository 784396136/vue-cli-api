<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;

class MemberController extends Controller
{
    // 注册
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
        else
        {
            // 将数据插入数据库
            $member = Member::create([
                'username' => $req->username,
                'password' => bcrypt($req->password)
            ]);
            return ok($member);
        }

        
    }

    // 登录
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'username'=>'required|min:6|max:18',
            'password'=>'required|min:6|max:18',
        ]);
        // 如果验证失败
        if($validator->fails())
        {
            // 获取错误信息
            $errors = $validator->errors();
            // 返回JSON数据和422状态码
            return error($errors,422);
        }
        else
        {
            // 查询用户
            $member = Member::select('id','password')->where('username',$req->username)->first();
            
            if($member)
            {
                // 判断密码
                if(Hash::check($req->password,$member->password))
                {
                    // 设置令牌过期时间
                    $now = time();
                    $expire = env('JWT_EXPIRE')+$now;
                    // 读取密钥
                    $key = env('JWT_KEY');
                    // 定义令牌中的数据
                    $data = [
                        'iat' => $now, // 当前时间
                        'exp' => $expire, // 过期时间
                        'id' => $member->id
                    ];

                    // 生成令牌
                    $jwt = JWT::encode($data,$key);

                    // 发送给前端
                    return ok([
                        'ACCESS_TOCKEN' => $jwt
                    ]);
                }
                else
                {
                    return error('密码错误',422);
                }
            }
            else
            {
                return error('用户名不存在',422);
            }
        }
    }
}
