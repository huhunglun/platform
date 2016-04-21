<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->string('vuforia_target_id')->unique();
            $table->string('vuforia_target_name');
            $table->string('name');
            $table->string('image_path');
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->double('scale');
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
        Schema::drop('targets');
    }
}
