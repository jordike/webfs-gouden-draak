<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::all()->load('customers');

        return inertia('BackOffice/Tables/Index', [
            'csrfToken' => csrf_token(),
            'tables' => $tables,
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
        $validated = $request->validate([
            'use_deluxe_menu' => 'required|boolean',
            'customers' => 'array|max:8',
            'customers.*.name' => 'nullable|string|max:255',
            'customers.*.age' => 'nullable|integer|min:0',
        ]);

        // Create the table
        $table = Table::create([
            'use_deluxe_menu' => $validated['use_deluxe_menu'],
        ]);

        if (!empty($validated['customers'])) {
            foreach ($validated['customers'] as $customer) {
                if (!empty($customer['name'])) {
                    $table->customers()->create([
                        'name' => $customer['name'],
                        'age' => $customer['age'],
                    ]);
                }
            }
        }

        return redirect()->route('backoffice.tables.index')
            ->with('success', 'Table created successfully.');
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
        $validated = $request->validate([
            'use_deluxe_menu' => 'required|boolean',
            'customers' => 'array|max:8',
            'customers.*.name' => 'nullable|string|max:255',
            'customers.*.age' => 'nullable|integer|min:0',
        ]);

        $table = Table::findOrFail($id);
        $table->use_deluxe_menu = $validated['use_deluxe_menu'];
        $table->save();

        $table->customers()->delete();

        if (!empty($validated['customers'])) {
            foreach ($validated['customers'] as $customer) {
                if (!empty($customer['name'])) {
                    $table->customers()->create([
                        'name' => $customer['name'],
                        'age' => $customer['age'],
                    ]);
                }
            }
        }

        return redirect()->route('backoffice.tables.index')
            ->with('success', 'Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $table = Table::findOrFail($id);
        $table->customers()->delete();
        $table->delete();

        return redirect()->route('backoffice.tables.index')
            ->with('success', 'Table deleted successfully.');
    }
}
