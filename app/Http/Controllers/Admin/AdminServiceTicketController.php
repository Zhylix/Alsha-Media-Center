<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceTicket;
use Illuminate\Http\Request;

class AdminServiceTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceTicket::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status') && array_key_exists($request->status, ServiceTicket::$statuses)) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        return view('admin.service_tickets.index', [
            'tickets'   => $tickets,
            'statuses'  => ServiceTicket::$statuses,
            'filters'   => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return view('admin.service_tickets.create', [
            'statuses' => ServiceTicket::$statuses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'device_type'   => 'required|in:pc,laptop,printer',
            'problem'       => 'required|string',
        ]);

        $validated['status'] = 'pending';

        $ticket = ServiceTicket::create($validated);

        $waUrl = $this->buildWhatsAppUrl($ticket, 'create');

        return redirect()->away($waUrl);
    }

    public function edit(ServiceTicket $serviceTicket)
    {
        return view('admin.service_tickets.edit', [
            'serviceTicket' => $serviceTicket,
            'statuses' => ServiceTicket::$statuses,
        ]);
    }

    public function update(Request $request, ServiceTicket $serviceTicket)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'device_type'   => 'required|in:pc,laptop,printer',
            'problem'       => 'required|string',
            'status'        => 'required|in:' . implode(',', array_keys(ServiceTicket::$statuses)),
        ]);

        $oldStatus = $serviceTicket->status;
        $serviceTicket->update($validated);

        if ($oldStatus !== $validated['status']) {
            $waUrl = $this->buildWhatsAppUrl($serviceTicket, 'update');
            return redirect()->away($waUrl);
        }

        return redirect()->route('admin.service-tickets.index')->with('success', 'Data servis berhasil diperbarui!');
    }

    public function destroy(ServiceTicket $serviceTicket)
    {
        $serviceTicket->delete();

        return redirect()->route('admin.service-tickets.index')->with('success', 'Data servis berhasil dihapus (soft delete).');
    }

    private function buildWhatsAppUrl(ServiceTicket $ticket, string $type): string
    {
        $phone = $this->formatPhone($ticket->phone);

        if ($type === 'create') {
            $message = "Halo {$ticket->customer_name},\n\n" .
                       "Kode servis Anda: {$ticket->service_code}.\n\n" .
                       "Status: Menunggu Pengecekan.\n\n" .
                       "Cek di:\n" .
                       url('/tracking') . "\n\n" .
                       "Terima kasih 🙏";
        } else {
            $statusLabel = $ticket->status_label;
            $message = "Halo {$ticket->customer_name},\n\n" .
                       "Status service Anda:\n\n" .
                       "{$statusLabel}\n\n" .
                       "Kode: {$ticket->service_code}\n\n" .
                       "Terima kasih 🙏";
        }

        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}

