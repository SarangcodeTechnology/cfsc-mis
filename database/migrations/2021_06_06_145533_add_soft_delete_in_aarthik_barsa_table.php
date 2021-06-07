<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteInAarthikBarsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->table('aarthik_barsa', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->table('aarthik_barsa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
