<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('staff_code', 'like', "%$s%"));
        }
        $staff = $query->paginate(15)->withQueryString();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_code' => 'required|string|unique:staff,staff_code',
            'name'       => 'required|string|max:100',
            'position'   => 'required|in:office,cleaner,security,other',
            'phone'      => 'nullable|string|max:20',
            'salary'     => 'nullable|numeric|min:0',
        ]);

        Staff::create($data);
        return redirect()->route('staff.index')->with('success', 'បានបន្ថែមបុគ្គលិកថ្មីដោយជោគជ័យ!');
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'staff_code' => 'required|string|unique:staff,staff_code,' . $staff->id,
            'name'       => 'required|string|max:100',
            'position'   => 'required|in:office,cleaner,security,other',
            'phone'      => 'nullable|string|max:20',
            'salary'     => 'nullable|numeric|min:0',
        ]);

        $staff->update($data);
        return redirect()->route('staff.index')->with('success', 'បានកែប្រែបុគ្គលិកដោយជោគជ័យ!');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'បានលុបបុគ្គលិកដោយជោគជ័យ!');
    }
}
