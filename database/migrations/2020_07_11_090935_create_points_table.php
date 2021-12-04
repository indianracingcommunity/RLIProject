<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('1')->default(0);
            $table->integer('2')->default(0);
            $table->integer('3')->default(0);
            $table->integer('4')->default(0);
            $table->integer('5')->default(0);
            $table->integer('6')->default(0);
            $table->integer('7')->default(0);
            $table->integer('8')->default(0);
            $table->integer('9')->default(0);
            $table->integer('10')->default(0);

            $table->timestamps();
        });

        Schema::table('races', function (Blueprint $table) {
            $table->unsignedInteger('points')->default(1);
            // $table->foreign('point_id')->references('id')->on('points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('races', function (Blueprint $table) {
            // $table->dropForeign('races_point_id_foreign');
            $table->dropColumn('points');
        });

        Schema::dropIfExists('points');
    }
}
