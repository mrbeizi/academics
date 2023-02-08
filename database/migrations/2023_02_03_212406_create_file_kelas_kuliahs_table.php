<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileKelasKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_kelas_kuliahs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kelaskuliah');
            $table->string('nama_file',100);
            $table->text('keterangan');
            $table->integer('id_periode');
            $table->timestamps();
            $table->integer('is_archived');
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
        Schema::dropIfExists('file_kelas_kuliahs');
    }
}
