<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function carrier(){
        return $this->hasOne(Carrier::class);
    }
    public function shipper(){
        return $this->hasOne(Shipper::class);
    }
    public function orders(){
        return $this->hasOne(Order::class);
    }
    
}
