<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ref_no', 'vehicle_no', 'vehicle_type', 'fuel_type', 'owner_name', 'owner_gender', 'owner_nic', 'owner_job', 'owner_workplace', 'perm_address', 'perm_district', 'temp_address', 'qrcode' , 'consumer_type', 'allowed_days', 'status', 'print_lock'
    ];

    //Table name
    protected $table = 'vehicles';

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
