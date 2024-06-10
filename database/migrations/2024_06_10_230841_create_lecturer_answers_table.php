<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer_answers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('answer');
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
            $table->foreignId('lecturer_questionnaire_id')->constrained('lecturer_questionnaires')->onDelete('cascade');
            $table->foreignId('lecturer_element_id')->constrained('lecturer_elements')->onDelete('cascade');
            $table->foreignId('lecturer_question_id')->constrained('lecturer_questions')->onDelete('cascade');
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
        Schema::dropIfExists('lecturer_answers');
    }
};
