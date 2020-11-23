<?php

namespace App\Exports;

use App\Fakultas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportFakultas implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Fakultas::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Fakultas',
            'Tanggal dibuat',
            'Tanggal diperbarui'
        ];
    }
}
