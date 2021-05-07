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
            $table->bigInteger('race_id')->unsigned()->after('reported_against');

            $table->foreign('reporting_driver')->references('id')->on('users');
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

            $table->dropColumn('race_id');
            $table->dropColumn('reporting_driver');
        });
    }
}
