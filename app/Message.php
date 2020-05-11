<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = ['message', 'user_id', 'broadcast_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
