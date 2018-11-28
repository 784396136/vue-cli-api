<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_attr extends Model
{
    // 指定表
    protected $table = 'goods_attribute';
    // 不更新时间
    public $timestamps = false;
}
