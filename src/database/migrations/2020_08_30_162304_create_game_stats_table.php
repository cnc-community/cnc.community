<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_stats', function (Blueprint $table) 
        {
            $table->id();
            $table->string("abbrev");
            $table->integer("players_online");
            $table->integer("order")->unsigned();
            $table->enum("type", ["game", "mod", "communityGame"]);
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
        Schema::dropIfExists('game_stats');
    }
}
