<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sku_id')->comment('商品SKU ID');
            $table->unsignedBigInteger('goods_id')->comment('商品ID');
            $table->decimal('price',10,2)->comment('商品单价');
            $table->unsignedBigInteger('goods_count')->comment('商品数量');
            $table->unsignedBigInteger('order_id')->comment('订单ID');
            $table->index('order_id');
            $table->comment = '订单商品表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods');
    }
}
