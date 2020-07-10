<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('games')->nullable();
            $table->string('developer')->nullable();
            $table->timestamps();
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->integer('series')->unsigned()->change();
            //$table->foreign('series')->references('id')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->integer('series')->change();
        });

        Schema::dropIfExists('series');
    }
}
