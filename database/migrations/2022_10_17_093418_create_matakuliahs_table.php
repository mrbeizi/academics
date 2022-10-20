<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode',50);
            $table->string('nama_id',200);
            $table->string('nama_en',200)->nullable();
            $table->string('nama_ch',200)->nullable();
            $table->integer('sks_teori');
            $table->integer('sks_praktek');
            $table->integer('golongan_fakultas');
            $table->integer('golongan_prodi');
            $table->unsignedInteger('id_periode');
            $table->foreign('id_periode')->references('id')->on('periodes');
            $table->integer('is_active');
            $table->integer('is_archived');
            $table->datetime('archived_at')->nullable();
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
        Schema::dropIfExists('matakuliahs');
    }
}
