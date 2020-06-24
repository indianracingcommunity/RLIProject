<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConstructorsInSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->string('constructors')->nullable();
            $table->float('isactive')->default(0)->change();
            $table->renameColumn('isactive', 'status');
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
            $table->renameColumn('status', 'isactive');
            $table->boolean('isactive')->default(0)->change();
            $table->dropColumn('constructors');
        });
    }
}
