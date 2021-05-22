<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Address extends Model
{
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function shipper(){
        return $this->hasMany(Shipper::class);
    }
    public function carrier(){
        return $this->hasMany(Carrier::class);
    }
    public function rates(){
        return $this->belongsToMany(Rate::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
