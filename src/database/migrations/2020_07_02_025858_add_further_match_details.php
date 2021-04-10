<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFurtherMatchDetails extends Migration
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
            $table->string('elos')->nullable();
            $table->text('names')->nullable();
            $table->string('teams')->nullable();
            $table->unsignedInteger('avgelo')->nullable();
            $table->string('cdnurl')->nullable();
            $table->string('colors')->nullable();
            $table->text('players')->nullable();
            $table->string('factions')->nullable();
            $table->string('locations')->nullable();
            $table->unsignedInteger('matchtype')->nullable();
            $table->string('wasrandom')->nullable();
            $table->unsignedInteger('winningteamid')->nullable();
            $table->text('aisettings')->nullable();
            $table->text('extramatchsettings')->nullable();
            $table->text('extraperplayersettings')->nullable();
            $table->text('matchduration')->nullable();
            $table->text('starttime')->nullable();
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
