<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceReviewRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_review_replies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('review_id')->unsigned();
            $table->foreign('review_id')
                ->references('id')->on('service_reviews')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('admins')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('comments');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('service_review_replies');
    }
}
