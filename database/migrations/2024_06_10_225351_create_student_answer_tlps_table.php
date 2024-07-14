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
        Schema::create('student_answer_tlps', function (Blueprint $table) {
            // $table->id();
            $table->tinyInteger('answer');
            $table->foreignId('student_questionnaire_id')->constrained('student_questionnaires')->onDelete('cascade');
            $table->foreignId('student_element_id')->constrained('student_elements')->onDelete('cascade');
            $table->foreignId('student_question_id')->constrained('student_questions')->onDelete('cascade');
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
        Schema::dropIfExists('student_answer_tlps');
    }
};
