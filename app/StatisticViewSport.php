<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatisticViewSport extends Model
{
    protected $table = 'statistic_views_sport';

    protected $fillable = ['visit_count', 'kind_sport_id', 'date'];

    public function kind_sport()
    {
        return $this->belongsTo(KindSport::class);
    }
}
