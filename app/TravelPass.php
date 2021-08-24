<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelPass extends Model
{
    //Table name
   protected $table = 'travelpass';

   //Primarykey
   public $primaryKey = 'id';

   //Timestamps
   public $timestamps = true;

   //link
      
   public function workplace()
   {
      return $this->belongsTo('App\Workplace');
   }

}
