<?php

namespace App\Http\Services\W3DHub;

interface GSHServerListingStatusInterface
{
    public function name(): string;
    public function map(): string;
    public function maxplayers(): int;
    public function numplayers(): int;
    public function started(): string;
    public function remaining(): string;
    public function teams(): array;
    public function players(): array;
    public function playerCount(): int;
}

class GSHServerListingStatus implements GSHServerListingStatusInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function name(): string { return $this->name; }
    public function map(): string { return $this->map; }
    public function maxplayers(): int { return $this->maxplayers; }
    public function numplayers(): int { return $this->numplayers; }
    public function started(): string { return $this->started; }
    public function remaining(): string { return $this->remaining; }
    public function teams(): array { return $this->teams; }
    public function players(): array { return $this->players; }
    public function playerCount(): int
    {
        return count($this->players);
    }
}