<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movernumber extends Model
{
    public function order(){
        return $this->hasOne(Order::class);
    }
}
