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
        // Debug: pastikan form POST benar-benar masuk ke controller
        Log::info('Tracking search called', [
            'code_raw' => $request->input('code'),
            'code_validated' => null,
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 200),
        ]);

        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim((string) $request->input('code')));

        // Debug after validation
        Log::info('Tracking search validated', [
            'code_validated' => $code,
        ]);

        $serviceTicket = ServiceTicket::where('service_code', $code)->first();

        if (! $serviceTicket) {
            return redirect()->route('tracking.index')
                ->with('error', 'Kode servis tidak ditemukan. Periksa kembali kode yang Anda masukkan.');
        }

        return view('tracking.result', compact('serviceTicket'));
    }
}

