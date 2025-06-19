<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Spatie\LaravelPdf\Facades\Pdf;

class SalesController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menuItem')
            ->orderBy('date_placed', 'desc')
            ->get();

        return inertia('BackOffice/Sales/Index', [
            'orders' => $orders
        ]);
    }

    public function export(Order $order)
    {
        set_time_limit(120);

        $pdf = Pdf::view('pdf', ['order' => $order])
            ->paperSize(8.5, 10, 'cm');

        $writer = new PngWriter();
        $qrCode = new QrCode(route('review.create', $order->id));
        $result = $writer->write($qrCode);
        $qrCodeDataUrl = $result->getDataUri();

        $pdf->view('pdf', [
            'order' => $order,
            'qrCode' => $qrCodeDataUrl
        ]);

        return $pdf->download('order-' . $order->id . '.pdf');
    }
}
