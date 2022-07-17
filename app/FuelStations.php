<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelStations extends Model
{
    //Model
    use SoftDeletes;

    protected $fillable = [
        'workplace_id', 'name', 'address', 'no_of_pumbs', 'station_type', 'contact_no', 'owner_name', 'status'
    ];

    //Table name
    protected $table = 'fuelstations';

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
