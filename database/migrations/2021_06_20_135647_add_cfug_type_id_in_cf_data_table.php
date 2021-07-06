<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCfugTypeIdInCfDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->table('cf_data', function (Blueprint $table) {
            $table->unsignedBigInteger('cfug_type_id')->nullable();
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
            $table->dropColumn('cfug_type_id');
        });
    }
}
