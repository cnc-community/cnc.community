<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameStat extends Model
{
    protected $table = 'game_stats';

    public const TYPE_MOD = "mods";
    public const TYPE_GAME = "games";
    public const TYPE_STANDALONE = "standalone";

    public static function getTotalPlayersOnline()
    {
        return GameStat::sum("players_online");
    }

    public static function getStatsByType($type)
    {
        return GameStat::where("type", $type)->get();
    }

    public static function createOrUpdateStat($abbrev, $playersOnline, $type, $order)
    {
        $gameStat = GameStat::where("abbrev", $abbrev)->where("type", $type)->first();
        if ($gameStat == null)
        {
            $gameStat = new GameStat();
        }
        $gameStat->abbrev = $abbrev;
        $gameStat->players_online = $playersOnline;
        $gameStat->type = $type;
        $gameStat->order = $order;
        $gameStat->save();
    }

    public function getOnlineCount() { return $this->online_count; }
}
