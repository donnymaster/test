<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'feedback';

    protected $fillable = ['user_name', 'user_email', 'message', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
