<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningTimes extends Model
{
    protected $fillable = ['location_id', 'day', 'open_time', 'close_time'];
    
    public function locations()
    {
        return $this->belongsTo(Location::class);
    }
}
