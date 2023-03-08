<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressKelasKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_kelas_kuliahs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_periode');
            $table->integer('id_fakultas');
            $table->integer('dekan_valid');
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
        Schema::dropIfExists('progress_kelas_kuliahs');
    }
}
