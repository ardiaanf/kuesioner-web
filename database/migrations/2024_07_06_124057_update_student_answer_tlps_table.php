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
        Schema::table('student_answer_tlps', function (Blueprint $table) {
            $table->foreignId('student_answer_detail_tlp_id')->after('answer')->constrained('student_answer_detail_tlps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_answer_tlps', function (Blueprint $table) {
            $table->dropColumn('student_answer_detail_tlp_id');
        });
    }
};
