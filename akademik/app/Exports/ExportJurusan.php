<?php

namespace App\Exports;

use App\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportJurusan implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jurusan::select('jurusans.id','jurusans.nama_jurusan','fakultas.nama_fakultas')->leftJoin('fakultas','jurusans.fakultas_id','=','fakultas.id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'jurusan',
            'fakultas',
        ];
    }
}
