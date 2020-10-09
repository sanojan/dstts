<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    //Table name
    protected $table = 'letters';

    //Primarykey
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    //link
    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function user(){
        return $this->belongsTo('App\User');
     }
}
