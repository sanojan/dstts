<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //table
    protected $table='subjects';

    //primary key
    public $primaryKey = 'id';

    //Timestamps
    public $timeStamps = true;

    public function user()
   {
      return $this->belongsTo('App\User');
   }
}
