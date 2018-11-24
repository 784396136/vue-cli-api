<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // 指定表
    protected $table = 'members';
    // 白名单
    protected $fillable = ['username','password'];
    // 自动更新时间
    public $timestamps = true;
    // 需要隐藏的字段
    protected $hidden = ['password','created_at','updated_at'];
}
