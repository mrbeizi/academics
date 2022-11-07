<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_periode');
            $table->string('kode_jabatan',20);
            $table->string('nama_in',100);
            $table->string('nama_en',100);
            $table->string('nama_ch',100);
            $table->integer('golongan');
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
        Schema::dropIfExists('jabatans');
    }
}
