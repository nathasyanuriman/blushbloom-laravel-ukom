<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function create(?Service $service = null)
    {
        return view('bookings.create', [
            'services' => Service::where('is_active', true)->orderBy('price')->get(),
            'selectedService' => $service
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'required',
            'event_location' => 'required|string|max:255',
            'event_type' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000'
        ]);

        $service = Service::where('is_active', true)->findOrFail($data['service_id']);

        Booking::create([
            ...$data,
            'customer_id' => session('user_id'),
            'status' => 'Menunggu',
            'payment_status' => 'Belum Dibayar',
            'total_price' => $service->price
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dikirim. Admin akan memeriksa pesanan kamu.');
    }

    public function adminIndex()
    {
        $bookings = Booking::with(['customer', 'service'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
    $data = $request->validate([
        'status' => 'sometimes|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan',
        'payment_status' => 'nullable|in:Belum Dibayar,Menunggu Verifikasi,Bayar di Tempat,Dibayar'
    ]);

    if (($data['payment_status'] ?? null) === 'Dibayar' && $booking->payment_status !== 'Dibayar') {
        if (!$booking->payment_method) {
            return back()->withErrors(['payment' => 'Belum bisa ditandai Dibayar: customer belum memilih metode pembayaran.']);
        }

        if ($booking->payment_method === 'QRIS' && !$booking->payment_proof) {
            return back()->withErrors(['payment' => 'Belum bisa ditandai Dibayar: bukti pembayaran QRIS belum diupload.']);
        }
    }

    $booking->update($data);

    return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->customer_id != session('user_id') || $booking->status !== 'Menunggu') {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function payForm(Booking $booking)
    {
        abort_if($booking->customer_id != session('user_id'), 403);

        if ($booking->status !== 'Dikonfirmasi' || $booking->payment_status === 'Dibayar') {
            return redirect()->route('dashboard')
                ->withErrors(['payment' => 'Booking ini belum bisa dibayar atau sudah lunas.']);
        }

        return view('customer.payment', compact('booking'));
    }

    public function payStore(Request $request, Booking $booking)
    {
        abort_if($booking->customer_id != session('user_id'), 403);
        abort_if($booking->status !== 'Dikonfirmasi' || $booking->payment_status === 'Dibayar', 403);

        $data = $request->validate([
            'payment_method' => 'required|in:QRIS,Tunai',
            'payment_proof' => 'required_if:payment_method,QRIS|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($data['payment_method'] === 'QRIS') {
            if ($booking->payment_proof) {
                Storage::disk('public')->delete($booking->payment_proof);
            }
            $booking->update([
                'payment_method' => 'QRIS',
                'payment_proof' => $request->file('payment_proof')->store('payments', 'public'),
                'payment_status' => 'Menunggu Verifikasi',
            ]);
            $message = 'Bukti pembayaran terkirim. Admin akan memverifikasi pembayaranmu.';
        } else {
            $booking->update([
                'payment_method' => 'Tunai',
                'payment_proof' => null,
                'payment_status' => 'Bayar di Tempat',
            ]);
            $message = 'Metode tunai dipilih. Silakan bayar langsung ke MUA.';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}