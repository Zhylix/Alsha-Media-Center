<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShipmentOption;
use Illuminate\Http\Request;

class AdminShipmentController extends Controller
{
    public function index()
    {
        $shipments = ShipmentOption::orderBy('price')->paginate(15);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('admin.shipments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'provider'       => 'required|string|max:100',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->has('is_active');
        ShipmentOption::create($data);
        return redirect()->route('admin.shipments.index')->with('success', 'Opsi pengiriman berhasil ditambahkan!');
    }

    public function edit(ShipmentOption $shipment)
    {
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, ShipmentOption $shipment)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'provider'       => 'required|string|max:100',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->has('is_active');
        $shipment->update($data);
        return redirect()->route('admin.shipments.index')->with('success', 'Opsi pengiriman berhasil diperbarui!');
    }

    public function destroy(ShipmentOption $shipment)
    {
        $shipment->delete();
        return redirect()->route('admin.shipments.index')->with('success', 'Opsi pengiriman berhasil dihapus!');
    }

    public function show(ShipmentOption $shipment) { return redirect()->route('admin.shipments.index'); }
}
