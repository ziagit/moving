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
        return $this->order()->with('addresses','shipperContacts','jobWithCarrier','movingtype','movingsize','officesize','movernumber','vehicle','supplies','items');
    }
    public function orderAddress()
    {
        return $this->order()->with('addresses');
    }
    public function carrier(){
        return $this->belongsTo(Carrier::class);
    }
    public function payouts(){
        return $this->belongsToMany(Payout::class);
    }
    public function refund(){
        return $this->hasOne(Refund::class);
    }
}
