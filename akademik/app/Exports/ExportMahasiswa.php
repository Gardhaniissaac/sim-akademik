<?php

namespace App\Exports;

use App\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMahasiswa implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mahasiswa::select('mahasiswas.id','mahasiswas.nim','profiles.nama_lengkap','jurusans.nama_jurusan','mahasiswas.created_at','mahasiswas.updated_at')->join('profiles','profiles.id','=','mahasiswas.profile_id')->join('jurusans','jurusans.id','=','mahasiswas.jurusan_id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nim',
            'nama',
            'jurusan',
            'tanggal dibuat',
            'tanggal diperbarui'
        ];
    }
}
