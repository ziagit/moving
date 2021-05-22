<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movingsize extends Model
{
    public function order(){
        return $this->hasOne(Order::class);
    }
}
