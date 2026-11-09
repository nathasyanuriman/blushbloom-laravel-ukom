@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-flower">✿</span> Blush & Bloom
        </a>
        
        <div class="side-label">MENU UTAMA</div>
        
        <a class="side-link" href="{{ route('admin.dashboard') }}">
            ▦ Dashboard
        </a>
        <a class="side-link" href="{{ route('admin.services') }}">
            ✿ Layanan Makeup
        </a>
        <a class="side-link" href="{{ route('admin.bookings') }}">
            ▣ Booking
        </a>
        <a class="side-link active" href="{{ route('admin.transactions') }}">
            ▤ Transaksi
        </a>

        <div class="side-bottom">
            <div class="user-mini">
                <span class="avatar">A</span>
                <div>
                    <strong>{{ session('user_name') }}</strong>
                    <small>Admin / MUA</small>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="side-link logout" type="submit">
                    ↪ Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="app-main">
        <header class="app-top">
            <div>
                <span class="kicker">KEUANGAN</span>
                <h1>Riwayat Transaksi</h1>
                <p>Daftar booking yang sudah dikonfirmasi atau selesai.</p>
            </div>
            
            <a class="btn btn-outline" href="{{ route('admin.dashboard') }}">
                ← Kembali ke Dashboard
            </a>
        </header>

        @include('partials.flash')

        <section class="panel">
            <div class="panel-heading">
                <div>
                    <h2>Daftar Transaksi</h2>
                    <p>{{ $bookings->count() }} transaksi tercatat</p>
                </div>
                
                <strong class="total-revenue">
                    Total: Rp {{ number_format($bookings->where('payment_status', 'Dibayar')->sum('total_price'), 0, ',', '.') }}
                </strong>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal Acara</th>
                            <th>Total</th>
                            <th>Status Booking</th>
                            <th>Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $booking->customer->name }}</td>
                                <td>{{ $booking->service->name }}</td>
                                <td>{{ $booking->event_date->format('d M Y') }}</td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status status-{{ strtolower($booking->status) }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    <form class="inline-form" method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $booking->status }}">
                                        
                                        <select name="payment_status">
                                            <option @selected($booking->payment_status === 'Belum Dibayar')>Belum Dibayar</option>
                                            <option @selected($booking->payment_status === 'Dibayar')>Dibayar</option>
                                        </select>
                                        
                                        <button class="btn btn-primary btn-xs" type="submit">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection