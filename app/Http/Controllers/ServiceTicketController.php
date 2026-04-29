<?php

namespace App\Http\Controllers;

use App\Models\ServiceTicket;
use Illuminate\Http\Request;

class ServiceTicketController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->input('code')));

        $serviceTicket = ServiceTicket::where('service_code', $code)->first();

        if (! $serviceTicket) {
            return redirect()->route('tracking.index')
                ->with('error', 'Kode servis tidak ditemukan. Periksa kembali kode yang Anda masukkan.');
        }

        return view('tracking.result', compact('serviceTicket'));
    }
}
