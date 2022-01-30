<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestiontypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questiontypes', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable()->default(0);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable()->default(null);
            $table->integer('order')->nullable()->default(0);
            $table->mediumText('description')->nullable();
            $table->tinyInteger('visibility')->nullable()->default(1);
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
        Schema::dropIfExists('questiontypes');
    }
}
