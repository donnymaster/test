<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InfoPopularTypeSport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_type_sports', function (Blueprint $table) {
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
        Schema::dropIfExists('statistic_type_sports');
    }
}
