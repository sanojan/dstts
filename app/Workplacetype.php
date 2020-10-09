<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workplacetype extends Model
{
    //table
    protected $table='workplace_types';

    //primary key
    public $primaryKey = 'id';

    //Time stamps
    public $timestamps = true;

    public function workplaces(){
        return $this->hasMany('App\Workplace');
    }
}
