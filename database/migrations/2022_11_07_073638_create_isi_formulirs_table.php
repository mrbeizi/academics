<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsiFormulirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_formulirs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nim');
            $table->integer('id_data_formulir');
            $table->text('isi_data');
            $table->integer('validate');
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
        Schema::dropIfExists('isi_formulirs');
    }
}
