<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
}
