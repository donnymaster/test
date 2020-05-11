<?php

namespace App\Services;

use App\Charts\ViewTypeSport;
use Illuminate\Support\Facades\DB;

class ServiceChartFeedback{

    public static function chart(){

        $chart = new ViewTypeSport;

        $data = DB::select('
            SELECT count(*) AS record, DATE(created_at) AS date_create FROM feedback
            WHERE DATE(created_at) > NOW() - INTERVAL 15 DAY
            GROUP BY date_create;
        ');
        $labels = array();
        $data_arrays = array();

        foreach ($data as $value) {

            array_push($labels, $value->date_create);
            array_push($data_arrays, $value->record);

        }

        $chart->labels($labels);
        $chart->dataset('Кількість запитань', 'bar', $data_arrays)->options([
            'backgroundColor' => ServiceColor::color('Покер'),
            'borderColor' => ServiceColor::color('Покер'),
        ]);



        // dd($chart);

        return $chart;

    }
}
