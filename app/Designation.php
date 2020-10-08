<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    //table
    protected $table='designations';

    //primary key
    public $primaryKey = 'id';

    //Time stamps
    public $timestamps = true;

}
