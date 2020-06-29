<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LeaderboardMatchHistory extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_match_history';
    
    public static function saveGame($matchIds, $matchPlayerId)
    {
        // Fucking sql #dontknowshit
        // Someone with an actual brain please fix this when you see it. Thanks!

        // $start = microtime(true);

        // Get the ids we know exist in the fast way possible
        $matchExists = LeaderboardMatchHistory::whereIntegerInRaw("match_id", $matchIds)
            ->where("match_player_id", "=", $matchPlayerId)
            ->select("match_id")
            ->get()
            ->toArray();

        // Flatten into just the match_ids's
        $existingMatchIds = [];
        foreach($matchExists as $match)
        {
            $existingMatchIds[] = $match["match_id"];
        }

        // Compare the two matchId arrays and create a query for the ids we want to insert
        $idsToInsert = array_merge(array_diff($matchIds, $existingMatchIds));
        
        $query = [];
        foreach($idsToInsert as $id)
        {
            $query[] = [
                'match_id' => $id,
                'match_player_id' => $matchPlayerId
            ];
        }

        LeaderboardMatchHistory::insert($query);

        // $time = microtime(true) - $start;
        // Log::debug("Save Match History Time Taken: ". $time);
    }
}
