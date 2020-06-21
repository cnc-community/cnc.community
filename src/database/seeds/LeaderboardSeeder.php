<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Leaderboard;
use App\LeaderboardHistory;
use App\Map;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_71_Map", "One Pass Fits All");
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_60_Map", "Monkey in the Middle");
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_74_Map", "Nowhere to Hide");
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_10_Map", "Red Sands");
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_1_Map", "Green Acres");
        $this->createMap("Mobius_Tiberian_Dawn_Multiplayer_96_Map", "Tiberium Garden");
        $this->createMap("Mobius_Red_Alert_Multiplayer_22_Map", "Path Beyond");
        $this->createMap("Mobius_Red_Alert_Multiplayer_D9_Map", "Snow Garden");
        $this->createMap("Mobius_Red_Alert_Multiplayer_E3_Map", "Warlords Lake");
        $this->createMap("Mobius_Red_Alert_Multiplayer_12_Map", "Raraku");
        $this->createMap("Mobius_Red_Alert_Multiplayer_11_Map", "Island Hoppers");
        $this->createMap("Mobius_Red_Alert_Multiplayer_10_Map", "First Come First Serve");
        $this->createMap("Mobius_Red_Alert_Multiplayer_9_Map", "North by Northwest");
        $this->createMap("Mobius_Red_Alert_Multiplayer_8_Map", "Shallow Grave");
        $this->createMap("Mobius_Red_Alert_Multiplayer_7_Map", "Ivory Wastelands");
        $this->createMap("Mobius_Red_Alert_Multiplayer_6_Map", "Isle of Fury");
        $this->createMap("Mobius_Red_Alert_Multiplayer_5_Map", "Keep off the grass");
        $this->createMap("Mobius_Red_Alert_Multiplayer_4_Map", "MAROONED II");
        $this->createMap("Mobius_Red_Alert_Multiplayer_3_Map", "Equal Opportunity");
        $this->createMap("Mobius_Red_Alert_Multiplayer_2_Map", "Middle Mayhem");
        $this->createMap("Mobius_Red_Alert_Multiplayer_1_Map", "Coastal Influence");
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

    private function createMap($internalId, $mapName)
    {
        $map = new Map();
        $map->internal_name = $internalId;
        $map->map_name = $mapName;
        $map->save();
    }
}
