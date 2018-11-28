<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn')->comment('订单号');
            $table->string('name')->comment('收货人');
            $table->string('tel')->comment('联系人电话');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('area')->comment('县');
            $table->string('address')->comment('详细地址');
            $table->decimal('total_fee',10,2)->comment('订单总价');
            $table->unsignedBigInteger('member_id')->comment('用户ID');
            $table->timestamp('pay_at')->comment('支付时间');
            $table->enum('status',[0,1])->default(0)->comment('订单状态 0未支付 1已支付');
            $table->timestamps();
            $table->comment = '订单表';
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
