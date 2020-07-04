<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'matches';

    public static function createMatch($matchResponse)
    {
        $match = new Match();

        $match->elos = json_encode($matchResponse["elos"]);
        $match->names = json_encode($matchResponse["names"]);
        $match->teams = json_encode($matchResponse["teams"]);
        $match->avgelo = $matchResponse["avgelo"];
        $match->cdnurl = $matchResponse["cdnurl"];
        $match->colors = json_encode($matchResponse["colors"]);
        $match->mapname = $matchResponse["mapname"];
        $match->matchid = $matchResponse["matchid"];
        $match->matchtype = $matchResponse["matchtype"];
        $match->starttime = $matchResponse["starttime"];
        $match->players = json_encode($matchResponse["players"]);
        $match->factions = json_encode($matchResponse["factions"]);
        $match->locations = json_encode($matchResponse["locations"]);
        $match->wasrandom = json_encode($matchResponse["wasrandom"]);
        $match->aisettings = json_encode($matchResponse["aisettings"]);
        $match->matchduration = $matchResponse["matchduration"];
        $match->winningteamid = $matchResponse["winningteamid"];
        $match->extramatchsettings = json_encode($matchResponse["extramatchsettings"]);
        $match->extraperplayersettings = json_encode($matchResponse["extraperplayersettings"]);

        $match->save();

        /*
                Match::updateOrCreate(
            ['elos' => json_encode($matchResponse["elos"])],
            ['names'  =>  json_encode($matchResponse["names"])],
            ['teams'  =>  json_encode($matchResponse["teams"])],
            ['avgelo'  =>  $matchResponse["avgelo"]],
            ['cdnurl'  =>  $matchResponse["cdnurl"]],
            ['colors'  =>  json_encode($matchResponse["colors"])],
            ['mapname'  =>  $matchResponse["mapname"]],
            ['matchid' =>  $matchResponse["matchid"]],
            ['matchtype' =>  $matchResponse["matchtype"]],
            ['starttime'  =>  $matchResponse["starttime"]],
            ['players' =>  json_encode($matchResponse["players"])],
            ['factions'  =>  json_encode($matchResponse["factions"])],
            ['locations'  =>  json_encode($matchResponse["locations"])],
            ['wasrandom'  =>  json_encode($matchResponse["wasrandom"])],
            ['aisettings'  =>  json_encode($matchResponse["aisettings"])],
            ['matchduration'  =>  $matchResponse["matchduration"]],
            ['winningteamid'  =>  $matchResponse["winningteamid"]],
            ['extramatchsettings'  =>  json_encode($matchResponse["extramatchsettings"])],
            ['extraperplayersettings'  =>  json_encode($matchResponse["extraperplayersettings"])]
        );
        */
    }

    public static function savePlayersFromMatch($matchResponse)
    {
        foreach($matchResponse["players"] as $key => $playerSteamOriginId)
        {
            $playerName = $matchResponse["names"][$key];

            MatchPlayer::savePlayer($playerSteamOriginId, $playerName);
        }
    }
}
