<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->renameColumn('`1`', '`P1`');
            $table->renameColumn('`2`', '`P2`');
            $table->renameColumn('`3`', '`P3`');
            $table->renameColumn('`4`', '`P4`');
            $table->renameColumn('`5`', '`P5`');
            $table->renameColumn('`6`', '`P6`');
            $table->renameColumn('`7`', '`P7`');
            $table->renameColumn('`8`', '`P8`');
            $table->renameColumn('`9`', '`P9`');
            $table->renameColumn('`10`', '`P10`');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->renameColumn('`P10`', '`10`');
            $table->renameColumn('`P9`', '`9`');
            $table->renameColumn('`P8`', '`8`');
            $table->renameColumn('`P7`', '`7`');
            $table->renameColumn('`P6`', '`6`');
            $table->renameColumn('`P5`', '`5`');
            $table->renameColumn('`P4`', '`4`');
            $table->renameColumn('`P3`', '`3`');
            $table->renameColumn('`P2`', '`2`');
            $table->renameColumn('`P1`', '`1`');
        });
    }
}
