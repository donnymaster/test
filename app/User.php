<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nick', 'email', 'password', 'avatar', 'role_id', 'is_default_photo'
    ];

    protected $attributes = [
        'role_id' => 1
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    public function avatar(){

        return asset($this->avatar);
    }

    public function feedback()
    {
        $this->hasOne(Feedback::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function moderator_message()
    {
        return $this->hasMany(ModeratorMessage::class);
    }
}
