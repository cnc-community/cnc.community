<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Leaderboard;
use App\LeaderboardHistory;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create("Red Alert 1vs1", "ra_1vs1");
        $this->create("Tiberian Dawn 1vs1", "td_1vs1");
    }

    private function create($name, $type)
    {
        $leaderboard = new Leaderboard();
        $leaderboard->name = $name;
        $leaderboard->type = $type;
        $leaderboard->save();

        $history = new LeaderboardHistory();
        $history->leaderboard_id = $leaderboard->id;
        $history->save();
    }
}
