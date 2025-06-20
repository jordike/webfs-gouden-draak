<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MenuCategory::with('items')->get();

        return inertia('BackOffice/Menu/Index', [
            'categories' => $categories,
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'newCategory' => 'nullable|string|max:255',
        ]);

        if ($request->input('category') == '__new__' && $request->filled('newCategory')) {
            $category = MenuCategory::firstOrCreate([
                'name' => $request->input('newCategory'),
            ]);
        } else {
            $category = MenuCategory::where('name', $request->input('category'))->firstOrFail();
        }

        $category->items()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('backoffice.menu.index')
            ->with('success', 'Menu-item succesvol aangemaakt.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'newCategory' => 'nullable|string|max:255',
        ]);

        $item = MenuItem::findOrFail($id);

        if ($request->input('category') == '__new__' && $request->filled('newCategory')) {
            $category = MenuCategory::firstOrCreate([
                'name' => $request->input('newCategory'),
            ]);
        } else {
            $category = MenuCategory::where('name', $request->input('category'))->firstOrFail();
        }

        $oldCategoryName = $item->category_name;

        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->category_name = $category->name;
        $item->save();

        if ($oldCategoryName && $oldCategoryName !== $category->name) {
            $oldCategory = MenuCategory::where('name', $oldCategoryName)->first();

            if ($oldCategory && $oldCategory->items()->count() === 0) {
                MenuCategory::where('name', $oldCategoryName)->delete();
            }
        }

        return redirect()->route('backoffice.menu.index')
            ->with('success', 'Menu-item succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        if ($item->category->items()->count() === 0) {
            MenuCategory::where('name', $item->category->name)->delete();
        }

        return redirect()->route('backoffice.menu.index')
            ->with('success', 'Menu-item succesvol verwijderd.');
    }

    public function download()
    {
        $categories = MenuCategory::with(['items' => function ($query) {
            $query->orderBy('id');
        }])->get();
        $pdf = Pdf::view('pdf.menu', ['categories' => $categories]);

        return $pdf->download('menu.pdf');
    }
}
