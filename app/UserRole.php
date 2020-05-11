<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'roles';

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
