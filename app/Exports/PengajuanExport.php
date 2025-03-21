<?php
namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajuanExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Pengajuan::with('pelanggan')
            ->get()
            ->map(function ($pengajuan) {
                return [
                    'Nama Pengaju'     => $pengajuan->pelanggan->nama ?? 'Tidak Diketahui',
                    'Nama Barang'      => $pengajuan->nama_barang,
                    'Jumlah'           => $pengajuan->jumlah,
                    'Status'           => $pengajuan->status == 1 ? 'Terpenuhi' : 'Belum Terpenuhi',
                    'Tanggal Pengajuan'=> $pengajuan->tgl_pengajuan,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Pengaju', 'Nama Barang', 'Jumlah', 'Status', 'Tanggal Pengajuan'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Lebar kolom Nama Pengaju
            'B' => 30, // Lebar kolom Nama Barang
            'C' => 10, // Lebar kolom Jumlah
            'D' => 15, // Lebar kolom Status
            'E' => 20, // Lebar kolom Tanggal Pengajuan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = Pengajuan::count() + 1;

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '007BFF'],
                ],
            ],
            "A1:E$rowCount" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
