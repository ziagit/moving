<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function items()
    {
        return $this->belongsToMany(Order::class)->withPivot('number')->withTimestamps();
    }
}
