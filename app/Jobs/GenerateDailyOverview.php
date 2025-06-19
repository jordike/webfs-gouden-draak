<?php

namespace App\Jobs;

use App\Models\DailyOverview;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GenerateDailyOverview implements ShouldQueue
{
    use Queueable, Dispatchable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $today = Carbon::today();
        $orders = Order::with(['items.menuItem'])->whereDate('date_placed', $today)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $headers = ['Order ID', 'Date Placed', 'Item Name', 'Amount', 'Subtotal', 'Order Total'];
        $sheet->fromArray($headers, null, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        $row = 1;
        $grandTotal = 0;

        foreach ($orders as $order) {
            $orderTotal = 0;
            foreach ($order->items as $item) {
                $subtotal = $item->amount * $item->menuItem->price;
                $orderTotal += $subtotal;
            }
            $firstItem = true;
            foreach ($order->items as $item) {
                $row++;
                $sheet->setCellValue('A' . $row, $firstItem ? $order->id : '');
                $sheet->setCellValue('B' . $row, $firstItem ? $order->date_placed : '');
                $sheet->setCellValue('C' . $row, $item->menuItem->name);
                $sheet->setCellValue('D' . $row, $item->amount);
                $subtotal = $item->amount * $item->menuItem->price;
                $sheet->setCellValue('E' . $row, $subtotal);
                $sheet->setCellValue('F' . $row, $firstItem ? $orderTotal : '');
                $firstItem = false;
            }
            $grandTotal += $orderTotal;
        }

        // Add total row
        $row++;
        $sheet->setCellValue('E' . $row, 'Total:');
        $sheet->setCellValue('F' . $row, $grandTotal);

        // Style total row
        $sheet->getStyle('E' . $row . ':F' . $row)->applyFromArray([
            'font' => ['bold' => true],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Add borders to all data
        $sheet->getStyle('A1:F' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        File::ensureDirectoryExists(storage_path('app/daily_overviews'));

        $writer = new Xlsx($spreadsheet);
        $filename = 'daily_overviews/daily_overview_' . $today->format('Y_m_d') . '.xlsx';
        $writer->save(storage_path("app/$filename"));

        DailyOverview::updateOrCreate(
            [ 'date' => $today ],
            [ 'file_path' => $filename ]
        );
    }
}
