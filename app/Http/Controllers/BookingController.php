<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

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
            'status' => 'required|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan', 
            'payment_status' => 'nullable|in:Belum Dibayar,Dibayar'
        ]);

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
}