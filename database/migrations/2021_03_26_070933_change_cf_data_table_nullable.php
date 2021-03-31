<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCfDataTableNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->table('cf_data', function (Blueprint $table) {
            $table->text('fug_name')->nullable()->change();
            $table->text('fug_code')->nullable()->change();
            $table->integer('cfid')->nullable()->change();
            $table->integer('province_id')->nullable()->change();
            $table->integer('district_id')->nullable()->change();
            $table->integer('local_level_id')->nullable()->change();
            $table->integer('physiography_id')->nullable()->change();
            $table->float('x')->nullable()->change();
            $table->float('y')->nullable()->change();
            $table->integer('subdivision_id')->nullable()->change();
            $table->text('approval_date_bs')->nullable()->change();
            $table->text('approval_date_ad')->nullable()->change();
            $table->text('approval_fy')->nullable()->change();
            $table->float('area_ha')->nullable()->change();
            $table->integer('hh')->nullable()->change();
            $table->integer('vegetation_type_id')->nullable()->change();
            $table->integer('forest_type_id')->nullable()->change();
            $table->integer('forest_condition_id')->nullable()->change();
            $table->integer('no_of_person_in_committee')->nullable()->change();
            $table->integer('women_in_committee')->nullable()->change();
            $table->text('remarks')->nullable()->change();
            $table->longText('approval_revision_date_bs')->nullable()->change();
            $table->longText('approval_revision_date_ad')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
