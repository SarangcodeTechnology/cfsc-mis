<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKharchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('cfsc_mis_data')->create('kharcha', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('fug_id')->nullable();
            $table->unsignedBigInteger('aarthik_barsa_id')->nullable();
            $table->unsignedBigInteger('kharcha_type_id')->nullable();
            $table->unsignedFloat('jamma')->nullable();
            $table->text('kaifiyat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('cfsc_mis_data')->dropIfExists('kharcha');
    }
}
