<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quali', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('race_id')->unsigned();
            $table->integer('constructor_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned();
            $table->string('laptime')->nullable();
            $table->string('tyre')->nullable();

            //21 is DNS, 22 is DNF, 23 is DSQ
            $table->integer('position')->default(21);
            $table->timestamps();

            $table->foreign('race_id')->references('id')->on('races');
            $table->foreign('constructor_id')->references('id')->on('constructors');
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
        Schema::dropIfExists('quali');
    }
}
