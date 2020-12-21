<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('twitch')->nullable();
            $table->string('youtube')->nullable();
            $table->string('xbox')->nullable();
            $table->string('psn')->nullable();
            $table->string('spotify')->nullable();
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
            $table->dropColumn('spotify');
            $table->dropColumn('psn');
            $table->dropColumn('xbox');
            $table->dropColumn('youtube');
            $table->dropColumn('twitch');
            $table->dropColumn('twitter');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
        });
    }
}
