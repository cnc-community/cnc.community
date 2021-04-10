<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('match_players');

        Schema::connection('mysql2')->create('match_players', function (Blueprint $table)
        {
            $table->id();
            $table->bigInteger("player_id")->unique(); // steam or origin id
            $table->string("player_name"); // string player name
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
        Schema::connection('mysql2')->dropIfExists('match_players');
    }
}
