<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('voucher_id')->unsigned();
            $table->foreign('voucher_id')
                ->references('id')->on('vouchers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('admin_users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('voucher_customers');
    }
}
