<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name_kh', 'like', "%$s%")
                ->orWhere('name_en', 'like', "%$s%")
                ->orWhere('code', 'like', "%$s%"));
        }
        $subjects = $query->paginate(15)->withQueryString();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_kh' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'code'    => 'required|string|max:20|unique:subjects,code',
        ]);

        Subject::create($data);
        return redirect()->route('subjects.index')
            ->with('success', 'បានបន្ថែមមុខវិជ្ជាថ្មីដោយជោគជ័យ!');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name_kh' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'code'    => 'required|string|max:20|unique:subjects,code,' . $subject->id,
        ]);

        $subject->update($data);
        return redirect()->route('subjects.index')
            ->with('success', 'បានកែប្រែមុខវិជ្ជាដោយជោគជ័យ!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('success', 'បានលុបមុខវិជ្ជាដោយជោគជ័យ!');
    }
}
