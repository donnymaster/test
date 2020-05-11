<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{

    protected $table = 'teams';

    protected $fillable = ['name', 'kind_sport_id', 'abbr', 'city', 'description', 'logo'];

    public function kind_sport()
    {
        return $this->belongsTo(KindSport::class);
    }

    public function players()
    {
        return $this->hasOne(Teams::class);
    }

    public function broadcast()
    {
        return $this->belongsTo(Broadcast::class);
    }
}
