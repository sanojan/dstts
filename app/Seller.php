<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
     //Table name
   protected $table = 'sellers';

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
