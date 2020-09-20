<?php

namespace App\Http\Services;

class AnniversaryWinner
{
    private $name;
    private $prize;

    public function __construct($name, $prize)
    {
        $this->name = $name;
        $this->prize = $prize;
    }

    public function name(): string { return $this->name; }
    public function prize(): string { return $this->prize; }
}