<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromCfDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->table('cf_data', function (Blueprint $table) {
            $table->dropColumn('hh');
            $table->dropColumn('population');
            $table->dropColumn('women_population');
            $table->dropColumn('men_population');
            $table->dropColumn('no_of_person_in_committee');
            $table->dropColumn('women_in_committee');
            $table->dropColumn('men_in_committee');
            $table->dropColumn('forest_based_industry_operations');
            $table->dropColumn('forest_based_tourism_operations');
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
            //
        });
    }
}
