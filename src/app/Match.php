<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'matches';

    public const TD_1vs1 = 1;
    public const RA_1vs1 = 2;
    public const RA_TD_FFG = 8;

    public static function test()
    {
        $matches = Match::where("matchtype", "=", 8)
            ->where("starttime", ">=", "1598972394")
            ->orderBy("starttime", "DESC")
            ->get();

        $playerList = [];

        foreach($matches as $match)
        {
            $players = json_decode($match->players);

            foreach($players as $key => $playerId)
            {
                $teams = json_decode($match->teams);
                $names = json_decode($match->names);
                $playerName = $names[$key];
                $teamId = $teams[$key];
                
                //
                // Count Games Played
                if (isset($playerList[$playerId]["games"]))
                {
                    $playerList[$playerId]["games"] = $playerList[$playerId]["games"] + 1; 
                } 
                else
                {
                    $playerList[$playerId]["games"] = 1;
                }

                // 
                // Count Wins + Losses
                if ($teamId == $match->winningteamid)
                {
                    // We won the match, add to current record
                    // Check we have a record of wins first
                    if (isset($playerList[$playerId]["wins"]))
                    {
                        $playerList[$playerId]["wins"] = $playerList[$playerId]["wins"] + 1; 
                    } 
                    else
                    {
                        $playerList[$playerId]["wins"] = 1;
                    }
                }
                else
                {
                    // We lost the match, add to current record
                    // Check we have a record of losses first
                    if (isset($playerList[$playerId]["losses"]))
                    {
                        $playerList[$playerId]["losses"] = $playerList[$playerId]["losses"] + 1; 
                    } 
                    else
                    {
                        $playerList[$playerId]["losses"] = 1;
                    }
                }

                // Defaults
                if (!isset($playerList[$playerId]["wins"]))
                {
                    $playerList[$playerId]["wins"] = 0;
                }
                
                if (!isset($playerList[$playerId]["losses"]))
                {
                    $playerList[$playerId]["losses"] = 0;
                }
                
                $playerList[$playerId]["player_id"] = $playerId;
                $playerList[$playerId]["player_name"] = $playerName;
            }
        }

        return Match::formatIntoCollection($playerList);


        return DB::connection('mysql2')->table('matches')
            ->where("starttime", ">=", "1598972394")
            ->select('names', DB::raw('count(*) as total'))
            ->orderBy(DB::raw('count(*)'), 'DESC')
            ->groupBy('names')
            ->paginate(50);
    }

    private static function formatIntoCollection($results)
    {
        $newResults = [];
        foreach($results as $k => $results)
        {
            $results["rank_points"] = $results["wins"] - $results["losses"];
            $results["points"] = $results["rank_points"] < 0 ? 0 : $results["rank_points"];
            $newResults[] = $results;
        }

        return collect($newResults);
    }

    private static function formatResultsWithKeys($results)
    {
        $count = 0;
        $keyedResults = [];
        foreach($results as $k => $v)
        {
            $keyedResults[$count][$k] = $v;
            $count++;
        }
        return $keyedResults;
    }


    public static function getMatchTypeByGameSlug($gameSlug)
    {
        if ($gameSlug == "red-alert")
        {
            return Match::RA_1vs1;
        }
        else if ($gameSlug == "tiberian-dawn")
        {
            return Match::TD_1vs1;
        }
    }

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
        return $match;
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
