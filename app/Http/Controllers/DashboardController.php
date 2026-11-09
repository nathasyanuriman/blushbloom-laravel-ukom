<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('user_role') === 'admin') {
            return view('admin.dashboard', [
                'totalBookings' => Booking::count(), 
                'waitingBookings' => Booking::where('status', 'Menunggu')->count(),
                'totalCustomers' => User::where('role', 'customer')->count(), 
                'totalServices' => Service::where('is_active', true)->count(),
                'totalRevenue' => Booking::where('payment_status', 'Dibayar')->sum('total_price'),
                'confirmedBookings' => Booking::where('status', 'Dikonfirmasi')->count(),
                'completedBookings' => Booking::where('status', 'Selesai')->count(),
                'bookings' => Booking::with(['customer', 'service'])->latest()->take(6)->get(),
            ]);
        }

        $bookings = Booking::with('service')
            ->where('customer_id', session('user_id'))
            ->latest()
            ->get();

        return view('customer.dashboard', compact('bookings'));
    }
}