<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGameInCircuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('circuits', function (Blueprint $table) {
            $table->string('game')->nullable();

            $table->bigInteger('series')->unsigned()->default(1);
            $table->foreign('series')->references('id')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('circuits', function (Blueprint $table) {
            $table->dropColumn('game');

            $table->dropForeign('circuits_series_foreign');
            $table->dropIndex('circuits_series_foreign');
            $table->dropColumn('series');
        });
    }
}
