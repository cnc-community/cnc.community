<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchPlayersSteamProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('match_players_steam_profile');

        Schema::connection('mysql2')->create('match_players_steam_profile', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedInteger("match_player_id");
            $table->string("avatar");
            $table->string("steam_name");
            $table->string("avatar_medium");
            $table->string("avatar_full");
            $table->string("avatar_hash");
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
        Schema::connection('mysql2')->dropIfExists('match_players_steam_profile');
    }
}
