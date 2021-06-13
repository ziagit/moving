<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public function shipper(){
        return $this->belongsTo(Shipper::class);
    }
}
