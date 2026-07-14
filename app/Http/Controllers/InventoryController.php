<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('category', 'like', "%$s%"));
        }
        $items = $query->paginate(15)->withQueryString();
        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'category'       => 'nullable|string|max:50',
            'quantity'       => 'required|integer|min:0',
            'condition'      => 'required|in:good,fair,poor,damaged',
            'location'       => 'nullable|string|max:100',
            'purchased_date' => 'nullable|date',
        ]);

        Inventory::create($data);
        return redirect()->route('inventory.index')->with('success', 'បានបន្ថែមសម្ភារៈថ្មីដោយជោគជ័យ!');
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'category'       => 'nullable|string|max:50',
            'quantity'       => 'required|integer|min:0',
            'condition'      => 'required|in:good,fair,poor,damaged',
            'location'       => 'nullable|string|max:100',
            'purchased_date' => 'nullable|date',
        ]);

        $inventory->update($data);
        return redirect()->route('inventory.index')->with('success', 'បានកែប្រែសម្ភារៈដោយជោគជ័យ!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'បានលុបសម្ភារៈដោយជោគជ័យ!');
    }
}
