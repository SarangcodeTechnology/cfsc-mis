<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCfDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('cf_data', function (Blueprint $table) {
            $database = DB::connection("cfsc_mis_data")->getDatabaseName();
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('local_level_id')->nullable();
            $table->string('ward')->nullable();
            $table->string('fug_name')->nullable();
            $table->string('fug_code')->nullable();
            $table->string('fug_pan_no')->nullable();
            $table->bigInteger('hh')->nullable();
            $table->text('population')->nullable();
            $table->text('women_population')->nullable();
            $table->text('men_population')->nullable();
            $table->unsignedDouble('area_ha')->nullable();
            $table->unsignedBigInteger('no_of_person_in_committee')->nullable();
            $table->unsignedBigInteger('women_in_committee')->nullable();
            $table->unsignedBigInteger('men_in_committee')->nullable();
            $table->string('scientific_forest_approval_date')->nullable();
            $table->double('scientific_forest_area_ha')->nullable();
            $table->text('forest_based_industry_operations')->nullable();
            $table->text('forest_based_tourism_operations')->nullable();
            $table->text('remarks')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->dropIfExists('cf_data');
    }
}
