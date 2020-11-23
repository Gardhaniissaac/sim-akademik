<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
	protected $table = 'jurusans';

    protected $guarded = [];

    public function getFakultas(){
    	return $this->belongsTo('App\Fakultas', 'fakultas_id');
    }

    public function getMahasiswas(){
    	return $this->hasMany('App\Mahasiswa', 'jurusan_id');
    }

    public function getDosens(){
    	return $this->hasMany('App\Dosen', 'jurusan_id');
    }

    public function getTus(){
    	return $this->hasMany('App\Tu', 'jurusan_id');
    }

    public function getKelas(){
    	return $this->hasMany('App\Kelas', 'jurusan_id');
    }
}
