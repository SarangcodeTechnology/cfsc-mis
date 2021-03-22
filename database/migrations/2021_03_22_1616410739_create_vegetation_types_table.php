<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVegetationTypesTable extends Migration
{

    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('vegetation_types', function (Blueprint $table) {

		$table->increments('id');
		$table->text('name');
		$table->text('code');

        });
    }

    public function down()
    {
        Schema::dropIfExists('vegetation_types');
    }
}