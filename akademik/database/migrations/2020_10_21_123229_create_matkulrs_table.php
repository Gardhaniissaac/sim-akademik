<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatkulrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matkulrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rencana_studi_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unique(["rencana_studi_id", "kelas_id"], 'uq_combination');
            $table->foreign('rencana_studi_id')->references('id')->on('rencanas')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
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
        Schema::dropIfExists('matkulrs');
    }
}
