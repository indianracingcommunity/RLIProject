<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveReportableInSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('reportable');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->boolean('report_game')->default(0);
            $table->unsignedBigInteger('counter_report')->nullable();
            // $table->foreign('counter_report')->references('id')->on('reports');
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
            $table->boolean('reportable')->default(0);
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('report_game');
            $table->dropColumn('counter_report');
        });
    }
}
