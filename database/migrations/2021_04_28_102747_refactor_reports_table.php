<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->renameColumn('explained', 'explanation');
            $table->renameColumn('verdict', 'verdict_message')->default('NFA');

            $table->string('verdict_time')->default('0')->after('proof');
            $table->float('verdict_pp')->default(0)->after('proof');
            $table->text('stewards_notes')->nullable()->after('proof');

            $table->dropColumn('track');
            $table->dropColumn('inquali');
            $table->dropColumn('rid');
            $table->dropColumn('reported_by');
            $table->dropColumn('against');
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
            $table->string('reported_by')->after('id');
            $table->integer('rid')->after('id');
            $table->boolean('inquali');
            $table->string('track');
            $table->string('against');

            $table->dropColumn('stewards_notes');
            $table->dropColumn('verdict_pp');
            $table->dropColumn('verdict_time');

            $table->renameColumn('verdict_message', 'verdict');
            $table->renameColumn('explanation', 'explained');
        });
    }
}
