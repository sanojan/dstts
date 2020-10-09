<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //table
    protected $table='services';

    //primary key
    public $primaryKey = 'id';

    //Timestamps
    public $timeStamps = true;
    
}
