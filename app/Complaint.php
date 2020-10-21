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
    public function letter(){
        return $this->hasOne('App\Letter');
    }
}
