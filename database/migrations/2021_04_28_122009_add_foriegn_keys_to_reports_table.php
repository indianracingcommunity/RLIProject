<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeysToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->bigInteger('reporting_driver')->unsigned()->after('id');
            $table->bigInteger('race_id')->unsigned()->after('id');
            $table->bigInteger('reported_against')->unsigned()->after('reporting_driver');

            $table->foreign('reporting_driver')->references('id')->on('drivers');
            $table->foreign('reported_against')->references('id')->on('drivers');

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
        Schema::table('reports', function (Blueprint $table) {
            $table->dropforeign(['race_id']);
            $table->dropForeign(['reporting_driver']);
            $table->dropForeign(['reported_against']);
            $table->dropColumn('reported_against');
            $table->dropColumn('race_id');
            $table->dropColumn('reporting_driver');
        });
    }
}
