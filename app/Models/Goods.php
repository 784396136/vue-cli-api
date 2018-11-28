<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    // 指定表
    protected $table = 'goods';
    // 不更新时间
    public $timestamps = false;

    // 关联属性表
    public function attirubtes()
    {
        return $this->hasMany(G_attr::class,'goods_id','id');
    }

    // 关联图片表
    public function images()
    {
        return $this->hasMany(G_image::class,'goods_id','id');
    }

    // 关联SKU表
    public function sku()
    {
        return $this->hasMany(G_sku::class,'goods_id','id');
    }
}
