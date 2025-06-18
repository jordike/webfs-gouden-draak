<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
}
