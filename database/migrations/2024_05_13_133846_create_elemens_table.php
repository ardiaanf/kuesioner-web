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
        Schema::create('elemens', function (Blueprint $table) {
            $table->id('id_elemen');
            $table->unsignedBigInteger('id_kuesioner');
            $table->string('nama_elemen', 200);
            $table->foreign('id_kuesioner')->references('id_kuesioner')->on('kuesioners');
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
        Schema::dropIfExists('elemens');
    }
};
