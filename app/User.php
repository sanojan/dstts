<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'dob', 'nic', 'mobile_no', 'designation', 'branch', 'service', 'class', 'workplace', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function workplace(){
        return $this->belongsTo('App\Workplace');
     }
    
    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function letters(){
        return $this->hasMany('App\Letter');
    }

    public function complaints(){
        return $this->hasMany('App\Complaint');
    }

    public function files(){
        return $this->hasMany('App\File');
    }
}
