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
        Schema::create('acad_staff_answers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('answer');
            $table->foreignId('acad_staff_id')->constrained('acad_staffs')->onDelete('cascade');
            $table->foreignId('acad_staff_questionnaire_id')->constrained('acad_staff_questionnaires')->onDelete('cascade');
            $table->foreignId('acad_staff_element_id')->constrained('acad_staff_elements')->onDelete('cascade');
            $table->foreignId('acad_staff_question_id')->constrained('acad_staff_questions')->onDelete('cascade');
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
        Schema::dropIfExists('acad_staff_answers');
    }
};
