<?php

namespace App\Exports;

use App\Models\IkmResponse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IkmResponseExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return IkmResponse::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Persyaratan',
            'Prosedur',
            'Waktu Pelayanan',
            'Biaya/Tarif',
            'Produk Spesifikasi',
            'Kompetensi Pelaksana',
            'Penanganan Pengaduan',
            'Saran',
            'Nilai Rata-rata',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->indikator_1,
            $row->indikator_2,
            $row->indikator_3,
            $row->indikator_4,
            $row->indikator_5,
            $row->indikator_6,
            $row->indikator_7,
            $row->saran,
            number_format($row->nilai_rata_rata, 2),
            $row->created_at->toDateTimeString(),
        ];
    }
}
