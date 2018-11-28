<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G_sku extends Model
{
    // 指定表
    protected $table = 'goods_sku';
    // 不更新时间
    public $timestamps = false;
}
