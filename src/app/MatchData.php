<?php

namespace App;

class MatchData
{
    public const RA_1vs1 = "RA_1vs1";
    public const TD_1vs1 = "TD_1vs1";

    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }
}