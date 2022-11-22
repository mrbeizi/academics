<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToGolMatakuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gol_matakuliahs', function (Blueprint $table) {
            $table->integer('id_fakultas')->nullable()->after('nama_golongan');
            $table->integer('id_prodi')->nullable()->after('id_fakultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gol_matakuliahs', function (Blueprint $table) {
            //
        });
    }
}
