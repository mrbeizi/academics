<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan_pegawais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_periode');
            $table->string('id_pegawai',20);
            $table->integer('id_jabatan');
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
        Schema::dropIfExists('jabatan_pegawais');
    }
}
