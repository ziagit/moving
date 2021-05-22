<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function locationtypes(){
        return $this->belongsToMany(Locationtype::class);
    }
    public function movingtype(){
        return $this->belongsTo(Movingtype::class);
    }
    public function movingsize(){
        return $this->belongsTo(Movingsize::class);
    }
    public function officesize(){
        return $this->belongsTo(Officesize::class); 
    }
    public function movernumber(){
        return $this->belongsTo(Movernumber::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    public function supplies()
    {
        return $this->belongsToMany(Supply::class)->withPivot('number')->withTimestamps();
    }
    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('number')->withTimestamps();
    }
    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }
    public function addresses(){
        return $this->belongsToMany(Address::class);
    }
    public function contact(){
        return $this->belongsTo(Contact::class);
    }
    public function job()
    {
        return $this->hasOne(Job::class);
    }
    public function jobWithStatus(){
        return $this->job()->with('carrier');
    }
    public function earning()
    {
        return $this->hasOne(Earning::class);
    }
}
