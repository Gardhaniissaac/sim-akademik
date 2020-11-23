<?php

namespace App\Exports;

use App\Transkrip;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTranskrip implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $mahasiswa_id;

    public function __construct($id){
    	$this->mahasiswa_id = $id;
    }

    public function collection()
    {
        return Transkrip::where('mahasiswa_id','=',$this->mahasiswa_id)->get();
    }
}
