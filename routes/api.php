<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// 测试
Route::post('test','TestController@test');

// 注册
Route::post('member',"MemberController@insert");
// 登录
Route::post('authorization',"MemberController@login");
// 商品列表
Route::get('goods',"GoodsController@index");

// 应用令牌的路由
Route::middleware(['jwt'])->group(function (){
    Route::post('address',"AddressController@index"); // 获取收货地址
    Route::post('addresses',"AddressController@insert"); // 添加收货地址

    Route::post('order',"OrderController@insert"); // 下订单
});

// 生成唯一订单号
Route::get('testSN',function(){
    return getOrderSn();
});