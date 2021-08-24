<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //Table name
    protected $table = 'files';

    //Primarykey
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    //link
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function workplace(){
        return $this->belongsTo('App\Workplace');
    }

    public function letters(){  
        return $this->hasMany('App\Letter');
    }
}
