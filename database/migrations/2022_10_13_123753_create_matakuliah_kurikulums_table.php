<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahKurikulumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah_kurikulums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kurikulum');
            $table->foreign('id_kurikulum')->references('id')->on('kurikulums');
            $table->string('kode_matakuliah',50);
            $table->string('semester',2);
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
        Schema::dropIfExists('matakuliah_kurikulums');
    }
}
