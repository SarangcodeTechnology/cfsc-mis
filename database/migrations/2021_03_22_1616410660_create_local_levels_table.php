<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalLevelsTable extends Migration
{
    public function up()
    {
        Schema::create('local_levels', function (Blueprint $table) {

		$table->increments('id');
		$table->integer('llid',);
		$table->integer('district_id',);
		$table->text('name');
		$table->text('type');

        });
    }

    public function down()
    {
        Schema::dropIfExists('local_levels');
    }
}