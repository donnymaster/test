<?php

namespace App\Services;

use App\StatisticTypeSport;
use App\StatisticViewSport;
use Illuminate\Support\Facades\DB;

class ServiceUpdateStatistic{
    public static function update($date, $table, $type_sport){

        $record = DB::select('select * from ' .$table. ' where date = \'' . $date . '\' and kind_sport_id = ' .$type_sport);

        if($record === array()){
            // create
            if($table == 'statistic_views_sport'){
                StatisticViewSport::create([
                    'visit_count' => 1,
                    'kind_sport_id' => $type_sport,
                    'date' => $date
                ]);
            }
            if($table == 'statistic_type_sports'){
                StatisticTypeSport::create([
                    'visit_count' => 1,
                    'kind_sport_id' => $type_sport,
                    'date' => $date
                ]);
            }
        }else{
            if($table == 'statistic_views_sport'){
                StatisticViewSport::where([
                    ['kind_sport_id', '=', $type_sport],
                    ['date', '=', $date]
                ])->increment('visit_count');
            }
            if($table == 'statistic_type_sports'){
                StatisticTypeSport::where([
                    ['kind_sport_id', '=', $type_sport],
                    ['date', '=', $date]
                ])->increment('visit_count');
            }
        }
    }
}
