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
        Schema::connection('mysql2')->dropIfExists('leaderboards');
        Schema::connection('mysql2')->dropIfExists('leaderboard_history');
        Schema::connection('mysql2')->dropIfExists('leaderboard_data');

        Schema::connection('mysql2')->create('leaderboards', function (Blueprint $table)
        {
            $table->id();
            $table->string("name");
            $table->enum("type", ["ra_1vs1", "td_1vs1"]);
            $table->timestamps();
        });

        Schema::connection('mysql2')->create('leaderboard_history', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedInteger("leaderboard_id")->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql2')->create('leaderboard_data', function (Blueprint $table)
        {
            $table->id();
            $table->integer("rank");
            $table->integer("wins");
            $table->integer("losses");
            $table->float("points");
            $table->unsignedInteger("match_player_id")->nullable();
            $table->unsignedInteger("leaderboard_history_id")->nullable();
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
        // Schema::dropIfExists('leaderboards');
        // Schema::dropIfExists('leaderboard_history');
        // Schema::dropIfExists('leaderboard_data');
    }
}
