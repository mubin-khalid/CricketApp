<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batsman_id');
            $table->unsignedBigInteger('bowler_id');
            $table->foreign('batsman_id')->references('id')->on('players');
            $table->foreign('bowler_id')->references('id')->on('players');
            $table->unsignedBigInteger('match_id');
            $table->foreign('match_id')->references('id')->on('matches');
            $table->integer('over_number')->default(1);
            $table->integer('bowl')->default(1);
            $table->boolean('0s')->default(0);
            $table->boolean('1s')->default(0);
            $table->boolean('2s')->default(0);
            $table->boolean('3s')->default(0);
            $table->boolean('4s')->default(0);
            $table->boolean('6s')->default(0);
            $table->boolean('wicket')->default(0);
            $table->boolean('extra')->default(0);
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
        Schema::dropIfExists('match_stats');
    }
}
