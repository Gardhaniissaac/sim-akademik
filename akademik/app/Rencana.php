<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
	protected $table = 'rencanas';

	protected $guarded = [];

    public function getMahasiswa(){
    	return $this->belongsTo('App\Mahasiswa','mahasiswa_id');
    }

    public function getMatkulr(){
    	return $this->hasMany('App\Matkulr','rencana_studi_id');
    }
}
