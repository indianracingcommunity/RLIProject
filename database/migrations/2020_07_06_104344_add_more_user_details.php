<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('indian')->nullable();
            $table->string('location')->default('-');
            $table->string('mothertongue')->nullable();
            $table->string('motorsport')->nullable();
            $table->string('driversupport')->nullable();
            $table->string('games')->nullable();
            $table->string('source')->nullable();
            $table->string('platform')->nullable();
            $table->string('device')->nullable();
            $table->string('devicename')->nullable();
            $table->dropColumn(['team', 'teammate']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('devicename');
            $table->dropColumn('device');
            $table->dropColumn('platform');
            $table->dropColumn('source');
            $table->dropColumn('games');
            $table->dropColumn('driversupport');
            $table->dropColumn('motorsport');
            $table->dropColumn('mothertongue');
            $table->dropColumn('location');
            $table->dropColumn('indian');

           
        });
    }
}
