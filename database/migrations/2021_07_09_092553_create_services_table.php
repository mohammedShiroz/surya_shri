<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('service_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail_image')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->mediumText('long_description')->nullable();
            $table->float('price')->nullable();
            $table->string('week_days')->nullable();
            $table->string('duration')->nullable();
            $table->string('order')->nullable()->default(null);
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
        Schema::dropIfExists('services');
    }
}
