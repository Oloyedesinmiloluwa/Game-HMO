<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gameplays extends Model
{
    protected $fillable = ['gameId', 'playerId', 'isHost', 'created_at', 'updated_at'];

}
