<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    protected $searchQuery;
    protected $startDate;
    protected $endDate;

    public function __construct($searchQuery, $startDate, $endDate)
    {
        $this->searchQuery = $searchQuery;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Penjualan::with('pelanggan')
            ->when($this->searchQuery, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->searchQuery . '%')
                    ->orWhereHas('pelanggan', function ($q) {
                        $q->where('nama', 'like', '%' . $this->searchQuery . '%');
                    });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('tgl_faktur', [$this->startDate, $this->endDate]);
            })
            ->orderBy('tgl_faktur')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Faktur',
            'Tanggal',
            'Nama Pelanggan',
            'Total Bayar (Rp)',
        ];
    }

    public function map($penjualan): array
    {
        return [
            $penjualan->no_faktur ?? '-',
            $penjualan->tgl_faktur ?? '-',
            $penjualan->pelanggan->nama ?? '-',
            'Rp ' . number_format($penjualan->total_bayar, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menentukan jumlah baris berdasarkan data yang diambil
        $lastRow = $this->collection()->count() + 1;  // Menambah 1 untuk header baris pertama

        // Mengatur style untuk header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '007BFF']],
        ]);

        // Mengatur border dinamis
        $sheet->getStyle("A1:D$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
    }


    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',
        ];
    }
}
