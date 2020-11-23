<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
	protected $table = 'kelas';

    protected $guarded = [];

    public function getJurusan(){
    	return $this->belongsTo('App\Jurusan','jurusan_id');
    }

    public function getPengajar(){
    	return $this->belongsTo('App\Dosen','pengajar_id');
    }

    public function getMatkulr(){
    	return $this->hasMany('App\Matkulr', 'kelas_id');
    }

    public function getMahasiswas()
    {
        return $this->belongsToMany('App\Mahasiswa','transkrips');
    }
}
