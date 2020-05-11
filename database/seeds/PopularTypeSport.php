<?php

use App\StatisticTypeSport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PopularTypeSport extends Seeder
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

                StatisticTypeSport::create([
                    'visit_count' => rand(56, 134),
                    'kind_sport_id' => $value,
                    'date' => \Carbon\CarbonImmutable::now()->subDays(30)->add($index, 'day')
                ]);

            }
        }
    }
}
