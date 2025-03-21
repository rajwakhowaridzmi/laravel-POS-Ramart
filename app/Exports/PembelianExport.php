<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PembelianExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    private $totalPembelian = 0;

    public function collection()
    {
        $pembelian = Pembelian::with('pemasok', 'detailPembelian.barang')->get();

        $this->totalPembelian = $pembelian->flatMap->detailPembelian->sum('sub_total');

        return $pembelian;
    }

    public function headings(): array
    {
        return [
            '#', 'Kode Masuk', 'Tanggal', 'Pemasok', 'Nama Barang', 
            'Harga Beli', 'Jumlah', 'Subtotal'
        ];
    }

    public function map($pembelian): array
    {
        $rows = [];
        foreach ($pembelian->detailPembelian as $key => $detail) {
            $rows[] = [
                $key + 1,
                $pembelian->kode_masuk,
                $pembelian->tanggal_masuk,
                $pembelian->pemasok->nama_pemasok ?? '-',
                $detail->barang->nama_barang ?? '-',
                'Rp. ' . number_format($detail->harga_beli, 0, ',', '.'),
                $detail->jumlah,
                'Rp. ' . number_format($detail->sub_total, 0, ',', '.'),
            ];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                
                $sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '007BFF']], // Primary color
                    'alignment' => ['horizontal' => 'center']
                ]);

                $sheet->getStyle("A1:H{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);

                foreach (range('A', 'H') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $sheet->mergeCells("A" . ($highestRow + 1) . ":G" . ($highestRow + 1));
                $sheet->setCellValue("A" . ($highestRow + 1), "Total Pembelian:");
                $sheet->setCellValue("H" . ($highestRow + 1), "Rp. " . number_format($this->totalPembelian, 0, ',', '.'));

                $sheet->getStyle("A" . ($highestRow + 1) . ":H" . ($highestRow + 1))->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '007BFF']], 
                    'alignment' => ['horizontal' => 'center']
                ]);
            },
        ];
    }
}
