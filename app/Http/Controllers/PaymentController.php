<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\StoreProfile;

class PaymentController extends Controller
{
    public function index()
    {
        $store          = StoreProfile::first();
        $bankTransfers  = PaymentMethod::where('type', 'bank_transfer')->where('is_active', true)->get();
        $eWallets       = PaymentMethod::where('type', 'e_wallet')->where('is_active', true)->get();
        $cod            = PaymentMethod::where('type', 'cod')->where('is_active', true)->first();
        return view('payment', compact('store', 'bankTransfers', 'eWallets', 'cod'));
    }
}
