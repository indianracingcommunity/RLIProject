<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameInSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('series'); // 0 - F1, 1 - AC, 2 - ACC
            $table->boolean('isactive')->default(0);
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
            $table->dropColumn('name');
            $table->dropColumn('series');
            $table->dropColumn('isactive');
        });
    }
}
