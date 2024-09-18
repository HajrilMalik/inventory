<?php
namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokBarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Barang::all();
    }

    public function headings(): array
    {
        return [
            'ID Barang',
            'Nama Barang',
            'Deskripsi',
            'Harga',
            'Stok',
            'Gambar',
        ];
    }
}