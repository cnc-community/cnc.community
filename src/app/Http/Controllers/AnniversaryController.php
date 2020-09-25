<?php

namespace App\Http\Controllers;

use App\Http\Services\AnniversaryWinner;

class AnniversaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public const EA_1_YEAR_CODE = "EA Play Pro 1 Year Subscription";
    public const EA_1_MONTH_CODE = "EA Play Pro 1 Month Subscription";
    public const STEAM_GIFT_CODE = "Steam Gift Card";

    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.anniversary', ["winners" => $this->displayWinners()]);
    }

    private function displayWinners()
    {
        //
        // 24th Sept 2020

        // 1x Year EA Subscription Code
        $winners["24/09/2020"][] = new AnniversaryWinner ("Mordoren", AnniversaryController::EA_1_YEAR_CODE);
        
        // 4x Monthly EA Subscription Codes
        $winners["24/09/2020"][] = new AnniversaryWinner("RAnuts", AnniversaryController::EA_1_MONTH_CODE);
        $winners["24/09/2020"][] = new AnniversaryWinner("Nightshade", AnniversaryController::EA_1_MONTH_CODE);
        $winners["24/09/2020"][] = new AnniversaryWinner("GroundScorePro", AnniversaryController::EA_1_MONTH_CODE);
        $winners["24/09/2020"][] = new AnniversaryWinner("yizst2", AnniversaryController::EA_1_MONTH_CODE);
        
        // 1x Steam Gift Card
        $winners["24/09/2020"][] = new AnniversaryWinner("devvv", AnniversaryController::STEAM_GIFT_CODE);


        return $winners;

        // 
        // 25th Sept 2020

        // 1x Year EA Subscription Code
        $winners["25/09/2020"][] = new AnniversaryWinner ("Name", AnniversaryController::EA_1_YEAR_CODE);
        
        // 6x Monthly EA Subscription Codes
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        
        // 2x Steam Gift Card
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::STEAM_GIFT_CODE);
        $winners["25/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::STEAM_GIFT_CODE);




        // 
        // 26th Sept 2020

        // 6x Monthly EA Subscription Codes
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        
        // 1x Steam Gift Card
        $winners["26/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::STEAM_GIFT_CODE);




        // 
        // 27th Sept 2020 

        // 1st Place RA 
        $winners["27/09/2020"][] = new AnniversaryWinner ("Name", AnniversaryController::EA_1_YEAR_CODE);

        // 1st Place TD
        $winners["27/09/2020"][] = new AnniversaryWinner ("Name", AnniversaryController::EA_1_YEAR_CODE);

        // Random Top 50 Place RA
        $winners["27/09/2020"][] = new AnniversaryWinner ("Name", AnniversaryController::EA_1_YEAR_CODE);

        // Random Top 50 Place TD
        $winners["27/09/2020"][] = new AnniversaryWinner ("Name", AnniversaryController::EA_1_YEAR_CODE);


        $winners["27/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["27/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["27/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        $winners["27/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::EA_1_MONTH_CODE);
        
        // 1x Steam Gift Card
        $winners["27/09/2020"][] = new AnniversaryWinner("Name", AnniversaryController::STEAM_GIFT_CODE);

        return $winners;
    }
}