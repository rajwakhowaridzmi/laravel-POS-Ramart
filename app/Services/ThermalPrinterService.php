<?php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Carbon\Carbon;

class ThermalPrinterService
{
    const LINE_WIDTH = 32;

    public function printStruk($penjualanData)
    {
        $connector = new WindowsPrintConnector("POS-58");
        $printer = new Printer($connector);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(2, 2);  
        $printer->text("RAMART\n");

        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);        
        $printer->text("Jl. Angkasa No. 123\n");
        $printer->text("Cianjur\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text(str_repeat('-', self::LINE_WIDTH) . "\n");

        // Info Transaksi
        $kasir = $penjualanData['kasir']['nama'] ?? 'Kasir';
        $pelanggan = $penjualanData['pelanggan']['nama'] ?? '-';

        $printer->setTextSize(1, 1);
        $printer->text(sprintf("%-12s: %s\n", "Invoice", $penjualanData['no_faktur']));
        $printer->text(sprintf("%-12s: %s\n", "Tanggal", Carbon::now()->format('d-m-Y H:i')));
        $printer->text(sprintf("%-12s: %s\n", "Kasir", $kasir));
        $printer->text(sprintf("%-12s: %s\n", "Pelanggan", $pelanggan));
        $printer->text(str_repeat('-', self::LINE_WIDTH) . "\n");

        // Detail Barang
        foreach ($penjualanData['barang'] as $item) {
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($item['nama_barang'] . "\n");

            $line = "  " . $item['jumlah'] . " x Rp" . number_format($item['harga_jual'], 0, ',', '.');
            $subtotal = "Rp" . number_format($item['sub_total'], 0, ',', '.');

            $lineLength = strlen($line);
            $subtotalLength = strlen($subtotal);

            if ($lineLength + $subtotalLength < self::LINE_WIDTH) {
                $spaces = str_repeat(' ', self::LINE_WIDTH - $lineLength - $subtotalLength);
                $printer->text($line . $spaces . $subtotal . "\n");
            } else {
                $printer->text($line . "\n");
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text($subtotal . "\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
            }
        }

        $printer->text(str_repeat('-', self::LINE_WIDTH) . "\n");

        // Total dan Pembayaran
        $total = "Rp" . number_format($penjualanData['total'], 0, ',', '.');
        $bayar = "Rp" . number_format($penjualanData['jumlah_bayar'], 0, ',', '.');
        $kembalian = "Rp" . number_format($penjualanData['kembalian'], 0, ',', '.');

        $printer->text($this->alignLeftRight("Total", $total));
        $printer->text($this->alignLeftRight("Bayar", $bayar));
        $printer->text($this->alignLeftRight("Kembalian", $kembalian));

        $printer->text(str_repeat('-', self::LINE_WIDTH) . "\n");

        // Footer
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("*** TERIMA KASIH ***\n");
        $printer->text("Barang yang sudah dibeli\n");
        $printer->text("tidak dapat dikembalikan\n");

        $printer->pulse(); // Buka laci jika ada
        $printer->cut();
        $printer->close();
    }

    private function alignLeftRight($left, $right, $lineWidth = self::LINE_WIDTH)
    {
        $space = $lineWidth - strlen($left) - strlen($right);
        return $left . str_repeat(" ", max(0, $space)) . $right . "\n";
    }
}
