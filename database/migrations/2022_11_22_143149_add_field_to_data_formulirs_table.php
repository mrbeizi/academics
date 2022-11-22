<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToDataFormulirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_formulirs', function (Blueprint $table) {
            $table->integer('is_select')->nullable()->after('is_archived');
            $table->integer('is_required')->nullable()->after('is_select');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_formulirs', function (Blueprint $table) {
            //
        });
    }
}
