<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_stats', function (Blueprint $table) {
            $table->integer("generals_online_players")->default(0)->after('steam_players_online');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_stats', function (Blueprint $table) {
            $table->dropColumn('generals_online_players');
        });
    }
};
