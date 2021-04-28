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
            
            $table->renameColumn('against','reported_against');
            $table->renameColumn('explained','explanation');
            $table->renameColumn('verdict','verdict_message');
            $table->string('verdict_time')->after('proof');
            $table->float('verdict_pp')->after('proof');
            $table->text('stewards_notes')->after('proof');
            $table->dropColumn('track');
            $table->dropColumn('inquali');
            $table->dropColumn('rid');
            $table->dropColumn('reported_by');


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
            $table->renameColumn('reported_against','against');
            $table->renameColumn('explanation','explained');
            $table->renameColumn('verdict_message','verdict');
            $table->dropColumn('verdict_time');
            $table->dropColumn('verdict_pp');
            $table->dropColumn('stewards_notes');
            $table->string('track');
            $table->boolean('inquali');
            $table->integer('rid')->after('id');
            $table->string('reported_by')->after('id');


        });
    }
}
