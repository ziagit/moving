<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movingtype extends Model
{
    public function orders(){
        return $this->hasOne(Order::class);
    }
}
