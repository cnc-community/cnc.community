<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaderboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('leaderboard', function (Blueprint $table) 
        {
            $table->id();
            $table->integer("rank");
            $table->integer("wins");
            $table->integer("losses");
            $table->float("points");
            $table->unsignedInteger("match_player_id")->nullable(); // find by player id
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
        Schema::connection('mysql2')->dropIfExists('leaderboard');
    }
}
