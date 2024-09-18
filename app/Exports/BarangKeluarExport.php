<?php
namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangKeluarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BarangKeluar::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Nama Pembeli',
            'Jumlah',
            'Total Transaksi',
            'Biaya Tambahan',
            'Tanggal Keluar',
        ];
    }
}