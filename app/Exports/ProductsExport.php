<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductsExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Satuan',
            'Kategori',
            'Deskripsi',
            'Stok',
            'Supplier',
            'Tanggal Masuk',
            'Tanggal Keluar',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Sisakan 4 baris header di atas tabel
                $sheet->insertNewRowBefore(1, 4);

                // ===== HEADER ATAS =====
                // Baris 1: Iqbal Production
                $sheet->setCellValue('A1', 'Iqbal Production');
                $a1 = $sheet->getStyle('A1');
                $a1->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('0D6EFD');
                $a1->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Baris 1 (kanan): PT. ARIA COIN
                $sheet->setCellValue('C1', 'PT. ARIA COIN');
                $sheet->mergeCells('C1:I1');
                $c1 = $sheet->getStyle('C1');
                $c1->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('0D6EFD');
                $c1->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Baris 2-3: Judul laporan
                $sheet->setCellValue('C2', 'Laporan Rekap Stok Produk Gudang');
                $sheet->mergeCells('C2:I2');
                $sheet->setCellValue('C3', 'Periode November 2025');
                $sheet->mergeCells('C3:I3');

                foreach (['C2', 'C3'] as $cell) {
                    $style = $sheet->getStyle($cell);
                    $style->getFont()->setBold(true)->setSize(13);
                    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Baris 4: tanggal cetak
                $sheet->setCellValue('I4', 'Dicetak: ' . date('d M Y H:i'));
                $sheet->getStyle('I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('I4')->getFont()->setSize(10)->setItalic(true)->getColor()->setRGB('666666');

                // ===== GAYA HEADER TABEL =====
                $sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => '0D6EFD']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ],
                ]);

                // BORDER seluruh tabel
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle('A5:I' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '999999']
                        ]
                    ]
                ]);

                // WARNA SELANG-SELING
                for ($r = 6; $r <= $lastRow; $r++) {
                    if ($r % 2 == 0) {
                        $sheet->getStyle("A{$r}:I{$r}")->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F3F6FA');
                    }
                }

                // RATA TENGAH semua kecuali Deskripsi
                $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B6:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E6:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // ===== FOOTER (TANDA TANGAN) =====
                $footerStart = $lastRow + 3;
                $sheet->setCellValue('G' . $footerStart, 'Mengetahui,');
                $sheet->setCellValue('G' . ($footerStart + 1), 'Kepala Logistik');
                $sheet->setCellValue('G' . ($footerStart + 5), '_____________________');

                // Rata kanan
                $sheet->getStyle('G' . $footerStart . ':I' . ($footerStart + 5))
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // ===== TAMBAHAN =====
                // Bold untuk label tanda tangan
                $sheet->getStyle('G' . $footerStart)->getFont()->setBold(true);
                $sheet->getStyle('G' . ($footerStart + 1))->getFont()->setBold(true);

                // Lebar kolom otomatis
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
