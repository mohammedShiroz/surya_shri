<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceQuestionsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_questions_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('answer_id')->unsigned();
            $table->foreign('answer_id')
                ->references('id')->on('answers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('service_questions_answers');
    }
}
