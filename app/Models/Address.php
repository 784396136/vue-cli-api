<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // 指定表
    protected $table = 'address';
    // 白名单
    protected $fillable = ['name','tel','province','city','area','address','is_default','member_id'];

    // 获取当前用户的收货地址
    public function getAll($member_id)
    {
        return Address::where('member_id',$member_id)->get()->toArray();
    }
}
