<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_name');
            $table->bigInteger('role_id');
            $table->boolean('admin');
            $table->boolean('coordinator');
            $table->boolean('steward');
            $table->boolean('signup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('roles', function (Blueprint $table) {
        $table->dropColumn('id');
        $table->dropColumn('role_name');
        $table->dropColumn('role_id');
        $table->dropColumn('admin');
        $table->dropColumn('coordinator');
        $table->dropColumn('steward');
        $table->dropColumn('signup');
    });
    }
}
