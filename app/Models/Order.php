<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 指定表
    protected $table = 'order';
    // 白名单
    protected $fillable = ['sn','name','tel','province','city','area','address','total_fee','member_id','status'];

    // 关联order_goods表
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods','order_id');
    }
}
