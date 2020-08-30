<?php

namespace App\Http\Services\W3DHub;

interface GSHServerListingInterface
{
    public function id(): string;
    public function game(): string;
    public function port(): int;
    public function region(): string;
    public function address(): string;
}

class GSHServerListing implements GSHServerListingInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;

            if ($k == "status")
            {
                $this->{$k} = new GSHServerListingStatus($v);
            }
        }
    }

    public function id(): string { return $this->id; }
    public function game(): string { return $this->game; }
    public function port(): int { return $this->port; }
    public function region(): string { return $this->region; }
    public function address(): string { return $this->address; }
    public function status(): GSHServerListingStatusInterface { return $this->status; }
}