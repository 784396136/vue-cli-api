<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    // 指定表
    protected $table = 'order_goods';
    // 不更新时间
    public $timestamps = false;
    // 白名单
    protected $fillable = ['sku_id','goods_id','price','goods_count','order_id'];

    // 关联订单表
    public function order()
    {
        $this->belongsTo('App\Models\Order','order_id');
    }
}
