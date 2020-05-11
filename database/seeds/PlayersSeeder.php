<?php

use Illuminate\Database\Seeder;
use App\Players;


class PlayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Players::class, 15)->create();
    }
}
