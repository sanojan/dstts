<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    //table
    protected $table='workplaces';

    //primary key
    public $primaryKey = 'id';

    //Time stamps
    public $timestamps = true;
    
    public function wokplacetype(){
        return $this->belongsTo('App\Workplacetype');
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function files(){
        return $this->hasMany('App\File');
    }

    public function travelpasses(){
        return $this->hasMany('App\TravelPass');
    }

    public function sellers(){
        return $this->hasMany('App\Seller');
    }
    public function vehicles(){
        return $this->hasMany('App\Vehicle');
    }
}
