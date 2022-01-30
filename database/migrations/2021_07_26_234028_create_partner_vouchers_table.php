<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_vouchers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->unsigned();
            $table->foreign('agent_id')
                ->references('id')->on('agents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('voucher_id')->unsigned();
            $table->foreign('voucher_id')
                ->references('id')->on('vouchers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('g_code')->nullable();
            $table->string('status');
            $table->string('is_deleted')->nullable();
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
        Schema::dropIfExists('partner_vouchers');
    }
}
