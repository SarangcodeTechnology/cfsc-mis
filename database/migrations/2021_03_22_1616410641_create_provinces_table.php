<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{

    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('provinces', function (Blueprint $table) {

		$table->increments('id');
		$table->text('name');

        });
    }

    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}