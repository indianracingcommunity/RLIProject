<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rid');
            $table->string('reported_by');
            $table->string('against');
            $table->string('track');
            $table->boolean('inquali')->default(0);
            $table->integer('lap');
            $table->text('explained');
            $table->text('verdict')->nullable();
            $table->string('proof');
            $table->boolean('resolved')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
