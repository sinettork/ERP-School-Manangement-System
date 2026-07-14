<?php

namespace App\Http\Controllers;

use App\Models\SchoolInformation;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $school   = SchoolInformation::first();
        $settings = Setting::pluck('value', 'key');
        return view('settings.index', compact('school', 'settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name'     => 'required|string|max:200',
            'address'         => 'required|string|max:255',
            'phone'           => 'required|string|max:30',
            'email'           => 'nullable|email',
            'items_per_page'  => 'required|integer|min:5|max:100',
            'currency_symbol' => 'required|string|max:5',
            'logo'            => 'nullable|image|max:2048',
        ]);

        $school = SchoolInformation::firstOrNew(['id' => 1]);
        $school->school_name = $data['school_name'];
        $school->address     = $data['address'];
        $school->phone       = $data['phone'];
        $school->email       = $data['email'] ?? null;

        if ($request->hasFile('logo')) {
            $school->logo = $request->file('logo')->store('school', 'public');
        }
        $school->save();

        Setting::set('items_per_page',  $data['items_per_page']);
        Setting::set('currency_symbol', $data['currency_symbol']);

        return redirect()->route('settings.index')
            ->with('success', 'បានរក្សាទុកការកំណត់ដោយជោគជ័យ!');
    }
}
