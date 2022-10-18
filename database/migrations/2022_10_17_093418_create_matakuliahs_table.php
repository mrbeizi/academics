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
            $table->string('nama_en',200);
            $table->string('nama_ch',200);
            $table->integer('sks_teori');
            $table->integer('sks_praktek');
            $table->integer('golongan_fakultas');
            $table->integer('golongan_prodi');
            $table->integer('id_periode');
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