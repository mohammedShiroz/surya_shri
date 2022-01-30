<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrwalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrwal_details', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->float('minimum_limit')->nullable();
            $table->float('maximum_limit')->nullable();
            $table->float('fee_amount')->nullable();
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
        Schema::dropIfExists('withdrwal_details');
    }
}
