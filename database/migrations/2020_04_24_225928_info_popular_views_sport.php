<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InfoPopularViewsSport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_views_sport', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visit_count');
            $table->unsignedBigInteger('kind_sport_id');
            $table->date('date');

            $table->foreign('kind_sport_id')->references('id')->on('kind_sports');

            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic_views_sport');
    }
}
