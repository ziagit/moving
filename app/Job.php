<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderDetail()
    {
        return $this->order()->with('addresses','shipperContacts','items','movingtype','movingsize','officesize','movernumber','vehicle','supplies');
    }
    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
    public function carrierDetail(){
        return $this->carrier()->with('user');
    }
    public function earning(){
        return $this->hasOne(Earning::class);
    }
}
