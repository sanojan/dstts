<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     //Table name
     protected $table = 'assignments';

     //Primarykey
     public $primaryKey = 'id';
 
     //Timestamps
     public $timestamps = true;

     //link
     public function letter()
     {
         return $this->belongsTo('App\Letter');
     }
     public function user()
     {
         return $this->belongsTo('App\User');
     }
}
