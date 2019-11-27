<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function records()
    {
        return $this->hasMany('App\Record');   // a genre has many records
    }

    public function orderedRecords()
    {
        return $this->hasMany('App\Record')->orderBy('artist');
    }
}