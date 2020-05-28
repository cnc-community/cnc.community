<?php

namespace App\Http\Services;

interface SteamPublishedFileInterface
{
    public function title(): string;
    public function publishedfileid(): string;
    public function file_url(): string;
    public function preview_url(): string;
    public function file_description(): string;
    public function time_created(): int;
    public function favorited(): int;
    public function views(): int;
    public function tags(): array;
    public function steamUrl(): string;
}

class SteamWorkShopItem implements SteamPublishedFileInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }

        if (!isset($this->file_url))
        {
            $this->file_url = "";
        }
    }

    public function favorited(): int { return $this->favorited; }
    public function views(): int { return $this->views; }
    public function publishedfileid(): string { return $this->publishedfileid; }
    public function title(): string{ return $this->title; }
    public function file_url(): string{ return $this->file_url; }
    public function preview_url(): string{ return $this->preview_url; }
    public function file_description(): string
    { 
        return strip_tags($this->file_description, "[b][i]");
    }
    public function time_created(): int{ return $this->time_created; }
    public function tags(): array{ return $this->tags; }
    public function steamUrl(): string { return "https://steamcommunity.com/sharedfiles/filedetails/?id=". $this->publishedfileid; }
    public function lifetime_playtime_sessions(): string { return $this->lifetime_playtime_sessions; }
}