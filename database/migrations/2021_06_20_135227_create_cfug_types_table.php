<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfugTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('cfug_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->dropIfExists('cfug_types');
    }
}
