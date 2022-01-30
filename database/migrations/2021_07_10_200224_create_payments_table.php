<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type');
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('booking_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_type');
            $table->double('paid_amount')->nullable();
            $table->double('paid_points')->nullable();
            $table->string('payment_status');
            $table->string('payment_signature');
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
        Schema::dropIfExists('payments');
    }
}
