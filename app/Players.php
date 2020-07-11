<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $fillable = ['name', 'email', 'password', 'last_login', 'nickname'];

    // public function games()
    // {
    //     return $this->hasMany('App\Games', 'schoolId', 'id');
    // }
    // has many through

    public function gamePlays()
    {
        return $this->hasMany('App\GamePlays', 'playerId', 'id');
    }
}
