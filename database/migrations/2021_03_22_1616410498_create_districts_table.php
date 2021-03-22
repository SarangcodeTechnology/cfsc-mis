<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{

    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('districts', function (Blueprint $table) {

		$table->increments('id');
		$table->integer('province_id',);
		$table->text('name');

        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
}