<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderPart;
use App\Models\OrderItem;
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
            'items.*.comment' => 'nullable|string',
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
                'comment' => $item['comment'],
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

    /**
     * Create parts for an order (max 8).
     */
    public function createParts(Request $request, $orderId)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:8',
        ]);
        $order = Order::findOrFail($orderId);
        $existing = $order->parts()->count();
        if ($existing + $request->count > 8) {
            return response()->json(['error' => 'Maximaal 8 delen per rekening.'], 422);
        }
        $created = [];
        for ($i = 1; $i <= $request->count; $i++) {
            $part = OrderPart::firstOrCreate([
                'order_id' => $order->id,
                'part_number' => $existing + $i,
            ]);
            $created[] = $part;
        }
        return response()->json($created);
    }

    /**
     * Assign order items (or part of their amount) to a part.
     * Expects: [{order_item_id, order_part_id, amount}]
     */
    public function assignItemsToParts(Request $request, $orderId)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.order_item_id' => 'required|integer|exists:order_items,id',
            'assignments.*.order_part_id' => 'required|integer|exists:order_parts,id',
            'assignments.*.amount' => 'required|integer|min:1',
        ]);
        foreach ($request->assignments as $a) {
            $item = OrderItem::findOrFail($a['order_item_id']);
            // If splitting, create a new OrderItem for the part
            if ($item->amount > $a['amount']) {
                $item->amount -= $a['amount'];
                $item->save();
                $newItem = $item->replicate();
                $newItem->amount = $a['amount'];
                $newItem->order_part_id = $a['order_part_id'];
                $newItem->save();
            } else {
                $item->order_part_id = $a['order_part_id'];
                $item->save();
            }
        }
        return response()->json(['success' => true]);
    }
}
