<?php

namespace App\Services;

use App\Charts\ViewTypeSport;
use Illuminate\Support\Facades\DB;

class ServiceChart{

    /**
     * Получаем chart по специцификации таблицы для вывода графиков, смотреть бд
     *
     * @param  string  $table
     * @param int $days
     * @return \App\Charts\ViewTypeSport
     */

    public static function chart($table, $days = 15){

        $chart = new ViewTypeSport;

        $data = DB::select('
                SELECT GROUP_CONCAT(visit_count ORDER BY ' . $table . '.date) as visits, kind_sports.name_kind_sport as name_sport
                FROM ' . $table . '
                INNER JOIN kind_sports
                ON kind_sports.id = ' . $table . '.kind_sport_id
                WHERE date > NOW() - INTERVAL ' . $days . ' DAY
                GROUP BY kind_sport_id;
        ');

        $dates = DB::select('
            SELECT date FROM ' . $table . ' WHERE date > NOW() - INTERVAL ' . $days . ' DAY GROUP BY date
        ');

        $good_dates = array();

        foreach ($dates as $value) {
            array_push($good_dates, $value->date);
        }

        $chart->labels($good_dates);

        foreach ($data as $value) {

            $chart->dataset($value->name_sport, 'line', array_map('intval', explode(',', $value->visits)))
                    ->options([
                        'fill' => false,
                        'backgroundColor' => ServiceColor::color($value->name_sport),
                        'borderColor' => ServiceColor::color($value->name_sport),
                        'borderWidth' => 4
                    ]);
        }
        return $chart;
    }
}
