<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function earnings(){
        return $this->belongsToMany(Earning::class);
    }
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
}
