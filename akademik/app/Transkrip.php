<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transkrip extends Model
{
	protected $table = 'transkrips';

	protected $guarded = [];

    public function getMahasiswa(){
    	return $this->belongsTo('App\Mahasiswa','mahasiswa_id');
    }

    public function getKelas(){
    	return $this->belongsTo('App\Kelas','kelas_id');
    }
}
