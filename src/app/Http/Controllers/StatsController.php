<?php

namespace App\Http\Controllers;

use App\Http\Services\CNCOnlineCount;

class StatsController extends Controller
{
    public function runTask()
    {
        $this->onlineCounts = new CNCOnlineCount();
        return $this->onlineCounts->getGameCounts();
    }
}
