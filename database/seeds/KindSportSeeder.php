<?php

use App\KindSport;
use Illuminate\Database\Seeder;

class KindSportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_sports = [
            'Футбол',
            'Баскетбол',
            'Бокс',
            'Хокей',
            'Біатлон',
            'Плавання',
            'Покер',
        ];

        foreach ($type_sports as $key => $value) {
            KindSport::create([
                'name_kind_sport' => $value
            ]);
        }
    }
}
