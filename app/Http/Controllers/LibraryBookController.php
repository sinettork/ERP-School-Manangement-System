<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use Illuminate\Http\Request;

class LibraryBookController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryBook::latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%$s%")->orWhere('author', 'like', "%$s%")->orWhere('isbn', 'like', "%$s%"));
        }
        $books = $query->paginate(15)->withQueryString();
        return view('library.index', compact('books'));
    }

    public function create()
    {
        return view('library.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:200',
            'author'             => 'nullable|string|max:100',
            'isbn'               => 'nullable|string|max:30',
            'category'           => 'nullable|string|max:50',
            'quantity'           => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'shelf_location'     => 'nullable|string|max:50',
        ]);

        LibraryBook::create($data);
        return redirect()->route('library.index')->with('success', 'បានបន្ថែមសៀវភៅថ្មីដោយជោគជ័យ!');
    }

    public function edit(LibraryBook $library)
    {
        return view('library.edit', compact('library'));
    }

    public function update(Request $request, LibraryBook $library)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:200',
            'author'             => 'nullable|string|max:100',
            'isbn'               => 'nullable|string|max:30',
            'category'           => 'nullable|string|max:50',
            'quantity'           => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'shelf_location'     => 'nullable|string|max:50',
        ]);

        $library->update($data);
        return redirect()->route('library.index')->with('success', 'បានកែប្រែសៀវភៅដោយជោគជ័យ!');
    }

    public function destroy(LibraryBook $library)
    {
        $library->delete();
        return redirect()->route('library.index')->with('success', 'បានលុបសៀវភៅដោយជោគជ័យ!');
    }
}
