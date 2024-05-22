<?php

namespace App\Http\Controllers;

use App\Http\Services\FeedHelper;
use App\Http\Services\Petroglyph\NineBitArmiesAPI;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Http\Services\SteamHelper;
use Illuminate\Http\Request;

class LadderController extends Controller
{
    private NineBitArmiesAPI $nineBitArmiesAPI;
    private SteamHelper $steamHelper;

    public function __construct()
    {
        $this->steamHelper = new SteamHelper();
        $this->nineBitArmiesAPI = new NineBitArmiesAPI();
    }

    public function getLadderIndex(Request $request)
    {
        $data = $this->nineBitArmiesAPI->getLeaderboard(200, 0);
        $data = json_decode(json_encode($data["ranks"]));

        return view(
            'pages.9bitarmies.ladder.listings',
            [
                'data' => $data,
                'gameName' => '9-Bit Armies: A Bit Too Far'
            ]
        );
    }
}
