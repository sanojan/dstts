<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    //table
    protected $table='workplaces';

    //primary key
    public $primaryKey = 'id';

    //Time stamps
    public $timestamps = true;
    
    public function wokplacetype(){
        return $this->belongsTo('App\Workplacetype');
    }
}
