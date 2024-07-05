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
        Schema::table('acad_staffs', function (Blueprint $table) {
            $table->foreignId('acad_staff_work_unit_id')->after('password')->constrained('acad_staff_work_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acad_staffs', function (Blueprint $table) {
            $table->dropColumn('acad_staff_work_unit_id');
        });
    }
};
