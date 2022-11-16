<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip',20);
            $table->string('nama_in',100);
            $table->string('nama_ch',20)->nullable();
            $table->string('jenis_kelamin',1);
            $table->string('tempat_lahir',100);
            $table->date('tanggal_lahir');
            $table->string('agama',100);
            $table->integer('id_status_pegawai');
            $table->date('tanggal_masuk');
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
        Schema::dropIfExists('pegawais');
    }
}
