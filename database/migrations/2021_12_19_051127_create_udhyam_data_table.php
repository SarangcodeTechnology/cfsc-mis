<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdhyamDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('udhyam_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kaaryalaya_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('local_level_id')->nullable();
            $table->string('ward')->nullable();
            $table->string('udhyam_name')->nullable();
            $table->unsignedBigInteger('udhyam_type_id')->nullable();
            $table->string('pan_vat_no')->nullable();
            $table->unsignedBigInteger('registration_type_id')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('registration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->dropIfExists('udhyam_data');
    }
}
