<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaderboardHistoryToMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('matches', function (Blueprint $table) 
        {
            $table->unsignedInteger('leaderboard_history_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('matches', function (Blueprint $table) 
        {
            $table->unsignedInteger('leaderboard_history_id')->nullable();
        });
    }
}
