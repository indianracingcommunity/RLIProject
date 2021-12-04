<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructorstandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructorstandings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('race_id')->unsigned();
            $table->string('drivers')->nullable();      // Contains the Driver IDs as an Array
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->foreign('race_id')->references('id')->on('races');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constructorstandings');
    }
}
