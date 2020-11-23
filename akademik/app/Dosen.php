<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
	protected $table = 'dosens';

    protected $guarded = [];

    public function getProfile(){
    	return $this->belongsTo('App\Profile','profile_id');
    }

    public function getJurusan(){
    	return $this->belongsTo('App\Jurusan', 'jurusan_id');
    }

    public function getMahasiswas(){
    	return $this->hasMany('App\Mahasiswa', 'wali_id');
    }
}
