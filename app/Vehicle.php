<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function order(){
        return $this->hasOne(Order::class);
    }
    public function rate(){
        return $this->hasOne(Rate::class);
    }
}
