<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendidiks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_periode');
            $table->unsignedInteger('id_pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawais');
            $table->unsignedInteger('id_jabatan');
            $table->foreign('id_jabatan')->references('id')->on('jabatans');
            $table->integer('fakultas');
            $table->integer('prodi');
            $table->integer('is_archived');
            $table->timestamps();
            $table->datetime('archived_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendidiks');
    }
}
