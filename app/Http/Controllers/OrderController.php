<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Address;
use App\Models\G_sku;
use App\Models\Order;
use App\Models\OrderGoods;
use DB;

class OrderController extends Controller
{
    // 下订单
    public function insert(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'address_id'=>'required',
            'goods'=>'required|JSON',
        ]);
        if($validator->fails())
        {
            $errors = $validator->errors();
            // 返回错误信息和状态码
            return error($errors,422);
        }
        
        // 根据地址ID查出地址
        $address = Address::where('member_id',$req->jwt->id)->where('id',$req->address_id)->first();
        if(!$address)
        {
            // 如果没有查询到地址就返回错误信息
            return error('无效的收货人地址',404);
        }

        // 验证购物车中的商品的库存并计算总价
        $goodsInfo = Json_decode($req->goods,true);
        // 循环计算出商品总价
        $totalFee = 0;
        foreach($goodsInfo as $k=>$v)
        {
            $skuInfo = G_sku::select('goods_id','stock','price')->where('id',$v)->first();
            
            if($skuInfo->stock > $v['buy_count'])
            {
                // 如果库存够
                $totalFee += $skuInfo->price * $v['buy_count'];
                // 把商品的ID和价格放到数组中
                $goodsInfo[$k]['goods_id'] = $skuInfo->goods_id;
                $goodsInfo[$k]['price'] = $skuInfo->price;
            }
            else
            {
                // 库存不够返回错误信息
                return error('库存不足',403);
            }
        }

        // 生成订单信息
        $sn = getOrderSn();
        $data = [
            'sn' => $sn,
            'name' => $address->name,
            'tel' => $address->tel,
            'province' => $address->province,
            'city' => $address->city,
            'area' => $address->area,
            'address' => $address->address,
            'total_fee' => $totalFee,
            'member_id' => $req->jwt->id,
            'status' => '0',
        ];

        // 开启事务
        DB::beginTransaction();

        $order = Order::create($data);
        if($order)
        {
            $_cartData = [];
            foreach($goodsInfo as $k=>$v)
            {
                $_cartData[] = new OrderGoods([
                    'sku_id' => $v['sku_id'],
                    'goods_id' => $v['goods_id'],
                    'price' => $v['price'],
                    'goods_count' => $v['buy_count'],
                ]);

                // 减少库存
                if(!G_sku::where('id',$v['sku_id'])->decrement('stock',$v['buy_count']))
                {
                    DB::rollBack();
                    return error('下单失败,请重试',500);
                }
            }

            // 添加数据到OrderGoods表
            if(!$order->goods()->saveMany($_cartData))
            {
                DB::rollBack();
                return error('下单失败,请重试',500);
            }
            else
            {
                DB::commit();
                return ok($order);
            }
        }
        else
        {
            DB::rollBack();
            return error('下单失败,请重试',500);
        }
    }
}
