<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobstatus extends Model
{
    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
