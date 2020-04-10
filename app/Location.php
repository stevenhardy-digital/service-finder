<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name','location', 'description', 'opening_hours', 'logo', 'longitude', 'latitude'];
     public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

     public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
