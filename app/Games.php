<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    // remove version
    protected $fillable = ['name', 'version']; //created_at
}
