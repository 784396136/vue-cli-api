<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;

class GoodsController extends Controller
{
    public function index(Request $req)
    {
        // 如果有id就是商品详情页
        if($req->id)
        {
            $id = max(1,(int)$req->id);
            $data = Goods::with('attirubtes','images','sku')
                    ->where('id', $id )
                    ->first();
            if($data)
            {
                // 判断商品是否上架
                if($data->is_on_sale=='y')
                {
                    return ok($data);
                }
                else
                {
                    return ok('商品已下架~');
                }
            }
            else
            {
                return error('商品不存在',404);
            }
                
        }
        // 如果有多个id就是购物车
        else if($req->ids)
        {
            $data = Goods::with('attirubtes','images','sku')
                    ->whereIn('id',explode(',',$req->ids))
                    ->get()
                    ->toArray();
            if(!$data==[])
            {
                return ok($data);
            }
            else
            {
                return error('商品不存在！',404);
            }
        }
        else
        {
            // 每页取的记录条数
            $perPage = max(1,(int)$req->per_page);
            // 排序的字段
            $sortBy = ($req->sortBy=='id' || $req->sortBy=='create_at') ? $req->sortBy : 'id';
            // 排序方式
            $order = ($req->order=='asc' || $req->order=='desc') ? $req->order : 'asc';
            $data = Goods::with('attirubtes','images','sku')
                    ->where('goods_name','like','%'.$req->keywords.'%')
                    ->where('is_on_sale','y')
                    ->orderBy( $sortBy , $order )
                    ->paginate( $perPage );
            if($data[0])
            {
                return ok($data);
            }
            else
            {
                return error('该商品不存在',404);
            }
        }
        
    }
}
