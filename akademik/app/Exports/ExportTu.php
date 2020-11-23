<?php

namespace App\Exports;

use App\Tu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTu implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tu::select('tus.id','profiles.nama_lengkap','jurusans.nama_jurusan','tus.created_at','tus.updated_at')->join('profiles','profiles.id','=','tus.profile_id')->join('jurusans','jurusans.id','=','tus.jurusan_id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nama',
            'jurusan',
            'tanggal dibuat',
            'tanggal diperbarui'
        ];
    }
}
