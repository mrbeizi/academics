<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasMengajarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_mengajars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kelaskuliah');
            $table->string('id_dosen',20);
            $table->string('nidn',10);
            $table->integer('is_nidn_pengganti');
            $table->integer('id_prodi');
            $table->integer('id_periode');
            $table->timestamps();
            $table->integer('is_deleted');
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivitas_mengajars');
    }
}
