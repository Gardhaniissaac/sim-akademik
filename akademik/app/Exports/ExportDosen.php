<?php

namespace App\Exports;

use App\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDosen implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dosen::select('dosens.id','dosens.nip','profiles.nama_lengkap','jurusans.nama_jurusan','dosens.jabatan','dosens.created_at','dosens.updated_at')->join('profiles','profiles.id','=','dosens.profile_id')->join('jurusans','jurusans.id','=','dosens.jurusan_id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nip',
            'nama',
            'jurusan',
            'jabatan',
            'tanggal dibuat',
            'tanggal diperbarui'
        ];
    }
}
