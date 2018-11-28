<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('收货人姓名');
            $table->string('tel')->comment('手机号码');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('area')->comment('县');
            $table->string('address')->comment('详细地址');
            $table->enum('is_default',[0,1])->default(0)->comment('是否默认 0 否 1 是');
            $table->unsignedBigInteger('member_id')->comment('用户ID');
            $table->timestamps();
            $table->index('member_id');
            $table->comment = '收货地址表';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
