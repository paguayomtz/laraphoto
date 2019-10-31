<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role', 'name', 'surname', 'nick', 'email', 'password',
    ];
   
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function images() {
        return $this->hasMany('App\Image');
    }

}
