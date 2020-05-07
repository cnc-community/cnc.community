<?php

namespace App\Http\Services;

interface SteamNewsPostInterface
{
    public function title(): string;
    public function gid(): int;
    public function url(): string;
    public function author(): string;
    public function contents();
    public function feedLabel();
}

class SteamFeedItem implements SteamNewsPostInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function title(): string { return $this->title; }
    public function gid():int { return $this->gid; }
    public function url():string { return $this->url; }
    public function author():string { return $this->author; }
    public function contents() { return $this->contents; }
    public function feedLabel() { return $this->feedLabel; }
}