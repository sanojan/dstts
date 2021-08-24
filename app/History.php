<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //Table name
    protected $table = 'histories';

    //Primarykey
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    //link
    public function task(){
        return $this->belongsTo('App\Task');
    }
}
