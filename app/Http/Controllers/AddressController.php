<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Address;
use Validator;

class AddressController extends Controller
{
    // 取出该用户的所有收货地址
    public function index(Request $req)
    {
        $address = new Address;
        $data = $address->getAll($req->jwt->id);
        if(!$data==[])
        {
            return ok($data);
        }
        else
        {
            return error('该用户还未添加收货地址',404);
        }
    }

    // 添加新收货地址
    public function insert(Request $req)
    {
        // 表单验证
        $validator = Validator::make($req->all(),[
            'name'=>'required',
            'tel'=>'required|regex:/^1[34578][0-9]{9}$/',
            'province'=>'required',
            'city'=>'required',
            'area'=>'required',
            'address'=>'required',
            'is_default'=>'required|min:0|max:1',
        ]);
        // 验证失败
        if($validator->fails())
        {
            $errors = $validator->errors();
            return error($errors,422);
        }
        
        // 获取表单提交的数据
        $data = $req->all();
        // 保存用户ID
        $data['member_id'] = $req->jwt->id;

        // 判断是否是默认收货地址
        if($data['is_default']==1)
        {
            // 如果是默认收货地址就先把该用户所有的收货地址设置为0 再添加
            Address::where('member_id',$data['member_id'])->update(['is_default'=>'0']);
            // 插入数据看
            $address = Address::create($data);
        }
        else
        {
            // 如果没有设置默认就直接插入数据库
            $address = Address::create($data);
        }

        return ok($address);

    }
}