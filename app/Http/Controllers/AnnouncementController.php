<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('postedBy')->latest();
        if ($request->filled('target_role')) {
            $query->where('target_role', $request->target_role);
        }
        $announcements = $query->paginate(15)->withQueryString();
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'content'     => 'required|string',
            'target_role' => 'required|in:teacher,student,parent,all',
        ]);

        $data['posted_by']    = auth()->id();
        $data['published_at'] = now();

        Announcement::create($data);
        return redirect()->route('announcements.index')
            ->with('success', 'បានបន្ថែមសេចក្ដីជូនដំណឹងដោយជោគជ័យ!');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'content'     => 'required|string',
            'target_role' => 'required|in:teacher,student,parent,all',
        ]);

        $announcement->update($data);
        return redirect()->route('announcements.index')
            ->with('success', 'បានកែប្រែសេចក្ដីជូនដំណឹងដោយជោគជ័យ!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')
            ->with('success', 'បានលុបសេចក្ដីជូនដំណឹងដោយជោគជ័យ!');
    }
}
