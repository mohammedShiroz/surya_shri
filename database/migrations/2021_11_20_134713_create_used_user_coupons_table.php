<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsedUserCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_user_coupons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')
                ->references('id')->on('agents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('coupon_id')->unsigned();
            $table->foreign('coupon_id')
                ->references('id')->on('user_coupon_codes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->foreign('booking_id')
                ->references('id')->on('service_bookings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('is_deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('used_user_coupons');
    }
}
