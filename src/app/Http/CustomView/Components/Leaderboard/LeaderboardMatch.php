<?php

namespace App\Http\CustomView\Components\Leaderboard;

use App\Http\CustomView\AbstractCustomView;
use App\LeaderboardHelper;
use App\Map;
use App\MatchPlayer;
use App\ViewHelper;

class LeaderboardMatch extends AbstractCustomView
{
    private $players = [];
    private $match;
    private $gameSlug;

    public function __construct($match, $leaderboardHistory, $matchPlayer, $gameSlug)
    {
        $this->match = $match;
        $this->gameSlug = $gameSlug;

        $this->buildPlayers(
            $this->match->players(),
            $leaderboardHistory
        );

        $this->orderMatchPlayerFirst($matchPlayer->player_id);
        $this->renderContents();
    }

    private function buildPlayers($players, $leaderboardHistory)
    {
        foreach($players as $k => $player)
        {
            $matchPlayer = MatchPlayer::findPlayer($player);

            $teams = json_decode($this->match->teams);
            $winningTeam = false;

            foreach($teams as $key => $teamId)
            {
                $playerId = $players[$key];

                if ($teamId == $this->match->winningTeamId() && $playerId == $matchPlayer->player_id)
                {
                    $winningTeam = true;
                }
            }

            $this->players[$matchPlayer->player_id]["playerName"] = ViewHelper::renderSpecialOctal($matchPlayer->playerName($leaderboardHistory));
            $this->players[$matchPlayer->player_id]["leaderboardProfile"] = $matchPlayer->leaderboardProfile($leaderboardHistory->id, $this->gameSlug);
            $this->players[$matchPlayer->player_id]["winLostState"] = $winningTeam;
        }
    }

    private function orderMatchPlayerFirst($playerId)
    {
        // Always ensure the player we're viewing matches for
        // have their name consistently first
        $new = $this->players[$playerId];
        unset($this->players[$playerId]);
        array_unshift($this->players, $new);
    }

    public function render()
    {
        ?>
        <div class="leaderboard-match">
            <?php foreach($this->players as $k => $player): ?>
                <?php new LeaderboardMatchPlayer($player, $k); ?>

                <?php if ($k == 0): ?>
                    <div class="leaderboard-match-details">
                        <div class="match-game-details">
                            <?php new LeaderboardMatchDetails
                            (
                                $this->match->mapName(), 
                                $this->match->mapPreview(), 
                                $this->match->matchDuration(),
                                $this->match->startTime()
                            ); 
                        ?>
                        </div>
                        <div class="match-game-status">
                            <?php foreach($this->players as $p): ?>
                                <div class="game-status <?php echo $p["playerName"]; ?> <?php echo $p["winLostState"] == true ? 
                                    "game-status--won": "game-status--lost"; ?>">
                                    <?php echo $p["winLostState"] == true ? "W ": "L" ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="match-other">
                            <a href="<?php echo $this->match->matchReplayUrl(); ?>" target="_blank" title="Download Replay of this game" class="download-replay">
                                <i class="icon icon-replay"></i> Download Replay
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}