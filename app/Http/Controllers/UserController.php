<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"));
        }
        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }
        $users = $query->paginate(15)->withQueryString();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'status'   => 'required|in:active,inactive',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'status'   => $data['status'],
        ]);
        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with('success', 'បានបន្ថែមអ្នកប្រើប្រាស់ថ្មីដោយជោគជ័យ!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'role'   => 'required|exists:roles,name',
        ]);

        $user->update(['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'], 'status' => $data['status']]);
        $user->syncRoles([$data['role']]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'បានកែប្រែអ្នកប្រើប្រាស់ដោយជោគជ័យ!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'មិនអាចលុបគណនីខ្លួនឯងបានទេ!');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'បានលុបអ្នកប្រើប្រាស់ដោយជោគជ័យ!');
    }
}
