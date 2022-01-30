<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_notifies', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id');
            $table->string('order_id');
            $table->string('payhere_amount');
            $table->string('payhere_currency');
            $table->string('status_code');
            $table->string('md5sig');
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
        Schema::dropIfExists('payment_notifies');
    }
}
