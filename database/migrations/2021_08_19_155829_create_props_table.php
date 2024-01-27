<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('props', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('plant_id');
            $table->string('color',16);
            $table->integer('height_fr')->nullable();
            $table->integer('height_to')->nullable();
            $table->integer('width_fr')->nullable();
            $table->integer('width_to')->nullable();
            $table->string('flowering_time',64)->nullable();
            $table->string('trimming_mo',24)->nullable();
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
        Schema::dropIfExists('props');
    }
}
