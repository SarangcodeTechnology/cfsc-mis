<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForestConditionsTable extends Migration
{

    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('forest_conditions', function (Blueprint $table) {

		$table->increments('id');
		$table->text('name');
		$table->text('code');

        });
    }

    public function down()
    {
        Schema::dropIfExists('forest_conditions');
    }
}