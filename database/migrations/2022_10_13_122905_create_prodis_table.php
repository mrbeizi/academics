<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_prodi',5);
            $table->string('kode_dikti',50);
            $table->integer('id_fakultas');
            $table->integer('id_periode');
            $table->string('nama_in',100);
            $table->string('nama_en',100);
            $table->string('nama_ch',100);
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
        Schema::dropIfExists('prodis');
    }
}
