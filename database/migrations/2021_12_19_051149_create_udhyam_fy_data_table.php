<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdhyamFyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('udhyam_fy_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('udhyam_id')->nullable();
            $table->unsignedBigInteger('aarthik_barsa_id')->nullable();
            $table->unsignedBigInteger('pratakchya_rojgari')->nullable();
            $table->unsignedBigInteger('apratakchya_rojgari')->nullable();
            $table->unsignedBigInteger('punji')->nullable();
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
        Schema::connection('cfsc_mis_data')->dropIfExists('udhyam_fy_data');
    }
}
