<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToCircuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('circuits', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->unique(['series', 'title', 'game'], 'circuits_id_unique');
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
            $table->dropForeign('circuits_series_foreign');
            $table->dropUnique('circuits_id_unique');
            $table->foreign('series')->references('id')->on('series');

            $table->dropColumn('title');
        });
    }
}
