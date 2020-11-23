<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tu extends Model
{
	protected $table = 'tus';

	protected $guarded = [];

    public function getProfile(){
    	return $this->belongsTo('App\Profile', 'profile_id');
    }

    public function getJurusan(){
    	return $this->belongsTo('App\Jurusan','jurusan_id');
    }
}
