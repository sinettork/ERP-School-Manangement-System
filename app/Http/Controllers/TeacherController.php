<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('user')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")
                ->orWhere('teacher_code', 'like', "%$s%")
                ->orWhere('phone', 'like', "%$s%"));
        }

        $teachers = $query->paginate(15)->withQueryString();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_code' => 'required|string|unique:teachers,teacher_code',
            'name'         => 'required|string|max:100',
            'gender'       => 'required|in:male,female,other',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:100',
            'position'     => 'required|in:subject,homeroom',
            'salary'       => 'nullable|numeric|min:0',
            'address'      => 'nullable|string|max:255',
            'photo'        => 'nullable|image|max:2048',
            'create_user'  => 'nullable|boolean',
            'password'     => 'nullable|string|min:8',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        if ($request->boolean('create_user') && $request->filled('email')) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($request->input('password', 'Teacher@1234')),
                'status'   => 'active',
            ]);
            $user->assignRole('teacher');
            $data['user_id'] = $user->id;
        }

        unset($data['create_user'], $data['password']);
        Teacher::create($data);

        return redirect()->route('teachers.index')
            ->with('success', 'បានបន្ថែមគ្រូបង្រៀនថ្មីដោយជោគជ័យ!');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['subjects', 'homeroomClasses', 'classSchedules.subject']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'teacher_code' => 'required|string|unique:teachers,teacher_code,' . $teacher->id,
            'name'         => 'required|string|max:100',
            'gender'       => 'required|in:male,female,other',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:100',
            'position'     => 'required|in:subject,homeroom',
            'salary'       => 'nullable|numeric|min:0',
            'address'      => 'nullable|string|max:255',
            'photo'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')
            ->with('success', 'បានកែប្រែព័ត៌មានគ្រូបង្រៀនដោយជោគជ័យ!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'បានលុបគ្រូបង្រៀនដោយជោគជ័យ!');
    }
}
