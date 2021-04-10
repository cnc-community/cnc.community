<?php

use App\Leaderboard;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(UserSeed::class);
        $this->call(PageSeeder::class);
        $this->call(LeaderboardSeeder::class);
    }
}
