<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalUsersBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_users_bank_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_name')->nullable();
            $table->mediumText('Remarks')->nullable();
            $table->string('billing_proof')->nullable();
            $table->string('nic_proof')->nullable();
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
        Schema::dropIfExists('withdrawal_users_bank_details');
    }
}
