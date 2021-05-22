<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function contact(){
        return $this->belongsTo(Contact::class);
    }
    public function address(){
        return $this->belongsTo(Address::class);
    }
/*     public function fullAddress(){
        return $this->address()->with('country');
    } */
    public function rate(){
        return $this->hasOne(Rate::class);
    }
    public function carrierpayment(){
        return $this->hasOne(Carrierpayment::class);
    }
    public function calendars(){
        return $this->hasMany(Calendar::class);
    }
    public function rateaddress(){
        return $this->rates()->with('srcdes');
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function earnings(){
        return $this->hasMany(Earning::class);
    }
}
