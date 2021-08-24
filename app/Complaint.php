<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //Table name
    protected $table = 'complaints';

    //Primarykey
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    //link
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function tasks()
   {
      return $this->hasMany('App\Task');
   }
}
