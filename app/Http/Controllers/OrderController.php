<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('BackOffice/Orders/Index', [
            'categories' => MenuCategory::with('items')->get(),
            'csrfToken' => csrf_token(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.amount' => 'required|integer|min:1',
        ]);

        $order = new Order();
        $order->date_placed = now();
        $order->save();

        foreach ($request->items as $item) {
            $menuItem = MenuItem::findOrFail($item['id']);
            $order->items()->create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'amount' => $item['amount'],
            ]);
        }

       return redirect()->route('backoffice.orders.index')
            ->with('success', 'Bestelling succesvol opgeslagen.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
