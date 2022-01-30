<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('track_id')->nullable();
            $table->string('payment_method');
            $table->string('payment_status');
            $table->double('total');
            $table->double('shipping_amount');
            $table->string('status');
            $table->string('delivery_status');
            $table->string('is_deleted');
            $table->dateTime('confirmed_date');
            $table->dateTime('rejected_date');
            $table->dateTime('canceled_date');
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
        Schema::dropIfExists('orders');
    }
}
