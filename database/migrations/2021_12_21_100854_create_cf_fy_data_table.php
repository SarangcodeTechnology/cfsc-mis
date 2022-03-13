<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfFyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('cf_fy_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('fug_id')->nullable();
            $table->unsignedBigInteger('aarthik_barsa_id')->nullable();
            $table->bigInteger('hh')->nullable();
            $table->text('population')->nullable();
            $table->text('women_population')->nullable();
            $table->text('men_population')->nullable();
            $table->unsignedBigInteger('no_of_person_in_committee')->nullable();
            $table->unsignedBigInteger('women_in_committee')->nullable();
            $table->unsignedBigInteger('men_in_committee')->nullable();
            $table->text('forest_based_industry_operations')->nullable();
            $table->text('forest_based_tourism_operations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_fy_data');
    }
}
