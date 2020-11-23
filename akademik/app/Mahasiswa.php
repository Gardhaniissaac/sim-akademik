<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
	protected $table = 'mahasiswas';

    protected $guarded = [];

    public function getProfile(){
    	return $this->belongsTo('App\Profile', 'profile_id');
    }

    public function getJurusan(){
    	return $this->belongsTo('App\Jurusan', 'jurusan_id');
    }

    public function getWali(){
    	return $this->belongsTo('App\Dosen', 'wali_id');
    }

    public function getRencanaStudi(){
    	return $this->hasOne('App\Rencana','mahasiswa_id');
    }

    public function getTranskrip(){
    	return $this->hasOne('App\Transkrip', 'mahasiswa_id');
    }

    public function getKelas()
    {
        return $this->belongsToMany('App\Kelas','transkrips');
    }
}
