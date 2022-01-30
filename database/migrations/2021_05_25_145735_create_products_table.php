<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('answer_tags')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('item_code')->nullable();
            $table->double('price')->nullable();
            $table->double('discount_price')->nullable();
            $table->tinyInteger('rep_percentage')->nullable();
            $table->double('rep_price')->nullable();
            $table->tinyInteger('is_negotiable')->nullable();
            $table->tinyInteger('is_deliverable')->nullable();
            $table->integer('stock')->nullable()->default(0);
            $table->string('description')->nullable();
            $table->mediumText('long_description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('PUBLISHED');
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
        Schema::dropIfExists('products');
    }
}
