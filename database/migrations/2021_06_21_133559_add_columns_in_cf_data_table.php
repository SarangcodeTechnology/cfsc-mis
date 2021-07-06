<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCfDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->table('cf_data', function (Blueprint $table) {
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('subdivision_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->table('cf_data', function (Blueprint $table) {
            $table->dropColumn(['division_id','subdivision_id']);
        });
    }
}
