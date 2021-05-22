<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
}
