<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatisticTypeSport extends Model
{
    protected $table = 'statistic_type_sports';

    protected $fillable = ['visit_count', 'kind_sport_id', 'date'];

    public function kind_sport()
    {
        return $this->belongsTo(KindSport::class);
    }

}
