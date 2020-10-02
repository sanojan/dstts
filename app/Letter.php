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
}