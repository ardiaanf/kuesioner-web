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
        Schema::create('response_datas', function (Blueprint $table) {
            $table->id('id_responData');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->unsignedBigInteger('id_jawaban');
            // $table->foreign('id_user')->references('id_user')->on('users');
            // $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaans');
            // $table->foreign('id_jawaban')->references('id_jawaban')->on('jawabans');
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
        Schema::dropIfExists('response_datas');
    }
};
