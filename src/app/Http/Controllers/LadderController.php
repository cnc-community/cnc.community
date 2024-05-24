<?php

namespace App\Http\Controllers;

use App\Http\Services\FeedHelper;
use App\Http\Services\Petroglyph\NineBitArmiesAPI;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Http\Services\SteamHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $data = $this->nineBitArmiesAPI->getLeaderboard();
        $steamLookup = $this->nineBitArmiesAPI->getSteamIdNameLookupTable();

        return view(
            'pages.9bitarmies.ladder.listings',
            [
                'data' => $data,
                'steamLookup' => $steamLookup,
                'gameName' => '9-Bit Armies: A Bit Too Far'
            ]
        );
    }
}
