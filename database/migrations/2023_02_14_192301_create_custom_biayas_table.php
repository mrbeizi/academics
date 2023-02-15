<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_biayas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_custom_biaya',50);
            $table->integer('id_periode');
            $table->integer('is_active');
            $table->integer('is_archive')->nullable();
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
        Schema::dropIfExists('custom_biayas');
    }
}
