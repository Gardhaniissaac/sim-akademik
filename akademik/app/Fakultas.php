<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
	protected $table = 'fakultas';

	protected $guarded = [];

    public function getJurusans(){
    	return $this->hasMany('App\Jurusan', 'fakultas_id');
    }
}
