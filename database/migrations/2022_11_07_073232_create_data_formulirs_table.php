<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataFormulirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_formulirs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_periode');
            $table->text('nama_data');
            $table->integer('no_urut');
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
        Schema::dropIfExists('data_formulirs');
    }
}
