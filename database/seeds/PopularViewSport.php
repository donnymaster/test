<?php

use App\StatisticViewSport;
use Illuminate\Database\Seeder;

class PopularViewSport extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,30) as $index) {

            foreach (range(1,7) as $value) {

                StatisticViewSport::create([
                    'visit_count' => rand(89, 230),
                    'kind_sport_id' => $value,
                    'date' => \Carbon\CarbonImmutable::now()->subDays(30)->add($index, 'day')
                ]);

            }
        }
    }
}
