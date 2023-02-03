<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGolKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gol_kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_golongan',100);
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
        Schema::dropIfExists('gol_kelas');
    }
}
