<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matkulr extends Model
{
	protected $table = 'matkulrs';

	protected $guarded = [];

    public function getRencana(){
    	return $this->belongsTo('App\Rencana', 'rencana_studi_id');
    }

    public function getKelas(){
    	return $this->belongsTo('App\Kelas', 'kelas_id');
    }
}
