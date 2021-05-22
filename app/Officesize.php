<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officesize extends Model
{
    public function order(){
        return $this->hasOne(Order::class);
    }
}
