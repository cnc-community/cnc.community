<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaderboardMatchHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('leaderboard_match_history');

        Schema::connection('mysql2')->create('leaderboard_match_history', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedInteger("match_player_id")->nullable();
            $table->unsignedInteger("match_id")->nullable();
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
        Schema::connection('mysql2')->dropIfExists('leaderboard_match_history');
    }
}
