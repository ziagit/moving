<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
}
