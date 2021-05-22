<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function orderDetail()
    {
        return $this->order()->with('addresses','shipper','contact','movingtype','movingsize','officesize','movernumber','vehicle','supplies');
    }
    public function orderAddress()
    {
        return $this->order()->with('addresses');
    }
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
}
