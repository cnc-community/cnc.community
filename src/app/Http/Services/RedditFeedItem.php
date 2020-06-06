<?php

namespace App\Http\Services;

interface RedditPostInterface
{
    public function title(): string;
    public function score(): int;
    public function permalink(): string;
    public function url(): string;
    public function commentCount(): int;
    public function postType();
}

class RedditFeedItem implements RedditPostInterface
{
    public const POST_HINT_IMAGE = "image";
    public const POST_HINT_VIDEO = "rich:video";

    public function __construct($json)
    {
        foreach($json->data as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function title(): string { return $this->title; }
    public function score():int { return $this->score; }
    public function permalink():string { return $this->permalink; }
    public function url():string { return $this->url; }
    public function commentCount():int { return $this->num_comments; }
    public function postType() { return isset($this->post_hint) ? $this->post_hint: ""; }
}