<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_kuliahs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kelaskuliah',25);
            $table->string('kode_matakuliah',10);
            $table->integer('id_prodi');
            $table->integer('id_periode');
            $table->integer('tahun_mahasiswa');
            $table->string('semester',99);
            $table->integer('id_status');
            $table->float('n_tugas1',3,2)->nullable();
            $table->float('n_tugas2',3,2)->nullable();
            $table->float('n_tugas3',3,2)->nullable();
            $table->float('n_uts',3,2)->nullable();
            $table->float('n_uas',3,2)->nullable();
            $table->datetime('w_uts')->nullable();
            $table->datetime('w_uas')->nullable();
            $table->timestamps();
            $table->integer('sync')->nullable();
            $table->integer('is_mbkm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_kuliahs');
    }
}
