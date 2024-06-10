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
        Schema::create('student_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->tinyInteger('min_range');
            $table->tinyInteger('max_range');
            $table->string('label');
            $table->foreignId('student_element_id')->constrained('student_elements')->onDelete('cascade');
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
        Schema::dropIfExists('student_questions');
    }
};
