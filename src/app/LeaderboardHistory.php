<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardHistory extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_history';
}
