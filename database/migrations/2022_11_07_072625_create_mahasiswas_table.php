<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nim');
            $table->integer('id_prodi');
            $table->integer('id_periode');
            $table->string('no_form',9);
            $table->string('nama_mahasiswa',50);
            $table->string('jenis_kelamin',1);
            $table->string('tempat_lahir',50);
            $table->datetime('tanggal_lahir');
            $table->string('agama',100);
            $table->integer('id_status_mahasiswa');
            $table->datetime('tanggal_masuk');
            $table->integer('nim_valid');
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
        Schema::dropIfExists('mahasiswas');
    }
}
