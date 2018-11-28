<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_image extends Model
{
    // 指定表
    protected $table = 'goods_image';
    // 不更新时间
    public $timestamps = false;
}
