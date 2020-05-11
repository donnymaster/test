<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeratorMessage extends Model
{
    protected $table = 'moderator_message';

    protected $fillable = ['message', 'user_id', 'broadcast_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
