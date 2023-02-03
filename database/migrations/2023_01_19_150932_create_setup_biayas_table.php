<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetupBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_biayas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_biaya',100);
            $table->integer('id_lingkup_biaya');
            $table->bigInteger('nilai');
            $table->integer('id_periode');
            $table->integer('is_archived')->nullable();
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
        Schema::dropIfExists('setup_biayas');
    }
}
