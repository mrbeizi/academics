<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelengkapKelasKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelengkap_kelas_kuliahs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kelaskuliah');
            $table->integer('id_periode');
            $table->text('keterangan')->nullable();
            $table->integer('id_karakter');
            $table->text('sarpras')->nullable();
            $table->string('rps',100)->nullable();
            $table->string('bahan_ajar',100)->nullable();
            $table->string('referensi',100)->nullable();
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
        Schema::dropIfExists('pelengkap_kelas_kuliahs');
    }
}
