<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('official')->nullable();
            $table->string('game')->nullable();     // Associated Game (Should match with game in seasons table)
            $table->string('logo')->nullable();     // Logo File Location
            $table->string('car')->nullable();      // Car Pic File Location
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
        Schema::dropIfExists('constructors');
    }
}
