<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $table = 'players';

    protected $fillable = ['name', 'surname', 'date_birth', 'game_number', 'team_id', 'avatar', 'kind_sport_id', 'city', 'description'];

    public function kind_sport()
    {
        return $this->belongsTo(KindSport::class);
    }

    public function teams()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
