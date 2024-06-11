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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reg_number')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('semester');
            $table->foreignId('study_program_id')->constrained('study_programs')->onDelete('cascade');
            $table->foreignId('student_class_id')->constrained('student_classes')->onDelete('cascade');
            $table->string('role')->default('student');
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
        Schema::dropIfExists('students');
    }
};
