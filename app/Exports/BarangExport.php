<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Barang::all();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Jenis Produk',
            'Keuntungan (%)',
            'Harga Jual',
            'Stok',
            'Status Barang',
        ];
    }

    public function map($barang): array
    {
        $statusMapping = [
            0 => 'Ditarik',
            1 => 'Dijual',
        ];

        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->produk->nama_produk ?? '-',
            $barang->persentase ?? '-',
            'Rp ' . number_format($barang->harga_jual, 0, ',', '.'), // Format Harga Jual dengan Rupiah
            $barang->stok,
            $statusMapping[$barang->status_barang] ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Kode Barang
            'B' => 25, // Nama Barang
            'C' => 20, // Jenis Produk
            'D' => 15, // Keuntungan (%)
            'E' => 15, // Harga Jual
            'F' => 10, // Stok
            'G' => 15, // Status Barang
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menentukan jumlah baris berdasarkan data yang diambil
        $lastRow = $this->collection()->count() + 1;  // Menambah 1 untuk header baris pertama

        // Mengatur style untuk header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '007BFF']],
        ]);

        // Mengatur border dinamis untuk seluruh data
        $sheet->getStyle("A1:G$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
    }
}
