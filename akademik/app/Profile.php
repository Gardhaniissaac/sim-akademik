<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $table = 'profiles';

    protected $guarded = [];

    public function getUser(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function getMahasiswas(){
    	return $this->hasMany('App\Mahasiswa','profile_id');
    }

    public function getDosens(){
    	return $this->hasMany('App\Dosen','profile_id');
    }

    public function getTus(){
    	return $this->hasMany('App\Tu','profile_id');
    }
}
