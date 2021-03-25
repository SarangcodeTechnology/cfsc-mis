<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->increments('id');
            $table->timestamps();
            $table->text('fug_name');
            $table->text('fug_code');
            $table->integer('cfid');
            $table->integer('province_id');
            $table->integer('district_id');
            $table->integer('local_level_id');
            $table->integer('physiography_id');
            $table->float('x');
            $table->float('y');
            $table->integer('subdivision_id');
            $table->text('approval_date_bs');
            $table->text('approval_date_ad');
            $table->text('approval_fy');
            $table->float('area_ha');
            $table->integer('hh');
            $table->integer('vegetation_type_id');
            $table->integer('forest_type_id');
            $table->integer('forest_condition_id');
            $table->integer('no_of_person_in_committee');
            $table->integer('women_in_committee');
            $table->text('remarks');
            $table->longText('approval_revision_date_bs');
            $table->longText('approval_revision_date_ad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_data');
    }
}
