<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerInBroadcast extends Model
{
    protected $table = 'players_broadcast';

    protected $fillable = ['team_1_players', 'team_2_players'];

    public function broadcast(){
        return $this->hasOne(Broadcast::class);
    }
}
