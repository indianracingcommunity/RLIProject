<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('season_id')->unsigned();
            $table->integer('circuit_id')->unsigned();
            $table->integer('round');
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons');
            $table->foreign('circuit_id')->references('id')->on('circuits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('races');
    }
}
