<?php

namespace App\Exports;

use App\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportKelas implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kelas::select('kelas.id','kelas.mata_kuliah','jurusans.nama_jurusan','profiles.nama_lengkap','kelas.created_at','kelas.updated_at')->join('jurusans','jurusans.id','=','kelas.jurusan_id')->join('dosens','dosens.id','=','kelas.pengajar_id')->join('profiles','profiles.id','=','dosens.profile_id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nama mata kuliah',
            'jurusan',
            'dosen pengajar',
            'tanggal dibuat',
            'tanggal diperbarui'
        ];
    }
}
