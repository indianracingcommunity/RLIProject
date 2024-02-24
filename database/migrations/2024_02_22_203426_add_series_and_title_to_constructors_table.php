<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeriesAndTitleToConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('constructors', function (Blueprint $table) {
            $table->unsignedBigInteger('series')->nullable();
            $table->string('title')->nullable();

            $table->foreign('series')->references('id')->on('series');
            $table->unique(['series', 'title', 'game'], 'constructors_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('constructors', function (Blueprint $table) {
            $table->dropForeign('constructors_series_foreign');
            $table->dropUnique('constructors_id_unique');

            $table->dropColumn('title');
            $table->dropColumn('series');
        });
    }
}
