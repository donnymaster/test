<?php

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
        $this->call(UserRoleSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(KindSportSeeder::class);
        // $this->call(TeamSeeder::class);
        // $this->call(PlayersSeeder::class);
        // $this->call(BroadcastSeeder::class);
        $this->call(FeedbackSeeder::class);
    }
}
