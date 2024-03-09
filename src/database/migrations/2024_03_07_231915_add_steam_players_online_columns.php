<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSteamPlayersOnlineColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_stats', function (Blueprint $table)
        {
            $table->integer("steam_players_online")->default(0);
        });

        Schema::table('game_stats_graph', function (Blueprint $table)
        {
            $table->integer("steam_players_online")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
