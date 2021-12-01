<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverstandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driverstandings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('race_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->integer('points')->default(0);

            // 21 is DNS, 22 is DNF, 23 is DSQ
            $table->integer('position')->default(21);
            $table->timestamps();

            $table->foreign('race_id')->references('id')->on('races');
            $table->foreign('driver_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driverstandings');
    }
}
