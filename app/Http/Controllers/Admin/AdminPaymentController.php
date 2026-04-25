<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::orderBy('type')->paginate(15);
        return view('admin.payments.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:bank_transfer,e_wallet,cod',
            'provider'       => 'required|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_name'   => 'nullable|string|max:255',
            'instructions'   => 'nullable|string',
        ]);
        $data['is_active'] = $request->has('is_active');
        PaymentMethod::create($data);
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function edit(PaymentMethod $payment)
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, PaymentMethod $payment)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|in:bank_transfer,e_wallet,cod',
            'provider'       => 'required|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_name'   => 'nullable|string|max:255',
            'instructions'   => 'nullable|string',
        ]);
        $data['is_active'] = $request->has('is_active');
        $payment->update($data);
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }

    public function show(PaymentMethod $payment) { return redirect()->route('admin.payments.index'); }
}
