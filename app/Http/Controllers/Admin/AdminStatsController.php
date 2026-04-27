<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class AdminStatsController extends Controller
{
    public function index()
    {
        $stats = Stat::orderBy('sort_order')->paginate(15);
        return view('admin.stats.index', compact('stats'));
    }

    public function create()
    {
        return view('admin.stats.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon'       => 'required|string|max:255',
            'label'      => 'required|string|max:255',
            'value'      => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        
        Stat::create($data);
        return redirect()->route('admin.stats.index')->with('success', 'Stat berhasil ditambahkan!');
    }

    public function edit(Stat $stat)
    {
        return view('admin.stats.edit', compact('stat'));
    }

    public function update(Request $request, Stat $stat)
    {
        $data = $request->validate([
            'icon'       => 'required|string|max:255',
            'label'      => 'required|string|max:255',
            'value'      => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? $stat->sort_order;
        
        $stat->update($data);
        return redirect()->route('admin.stats.index')->with('success', 'Stat berhasil diperbarui!');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();
        return redirect()->route('admin.stats.index')->with('success', 'Stat berhasil dihapus!');
    }

    public function show(Stat $stat)
    {
        return redirect()->route('admin.stats.index');
    }
}
