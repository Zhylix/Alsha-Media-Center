<?php

namespace App\Http\Controllers;

use App\Models\ServiceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceTicketController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        Log::info('Tracking search called', [
            'code_raw' => $request->input('code'),
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 200),
        ]);

        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim((string) $request->input('code')));

        Log::info('Tracking search validated', [
            'code_validated' => $code,
        ]);

        // 1) Primary: lookup as service ticket code
        $serviceTicket = ServiceTicket::where('service_code', $code)->first();
        if ($serviceTicket) {
            return view('tracking.result', compact('serviceTicket'));
        }

        // 2) Fallback: lookup as order number (so AMC-... still works if user is using wrong tracking page)
        $order = \App\Models\Order::where('order_number', $code)->with('service')->first();
        if (! $order) {
            return redirect()->route('tracking.index')
                ->with('error', 'Kode tidak ditemukan. Periksa kembali kode yang Anda masukkan.');
        }

        return view('order-track', ['order' => $order]);
    }

}

