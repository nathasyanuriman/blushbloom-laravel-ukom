@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-flower">✿</span> Blush & Bloom
        </a>
        
        <div class="side-label">MENU UTAMA</div>
        
        <a class="side-link active" href="{{ route('admin.dashboard') }}">
            ▦ Dashboard
        </a>
        <a class="side-link" href="{{ route('admin.services') }}">
            ✿ Kelola Layanan
        </a>
        <a class="side-link" href="{{ route('admin.bookings') }}">
            ▣ Booking
        </a>
        <a class="side-link" href="{{ route('admin.transactions') }}">
            ▤ Transaksi
        </a>

        <div class="side-bottom">
            <div class="user-mini">
                <span class="avatar">
                    {{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}
                </span>
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

    <main class="app-main admin-dashboard-main">
        <header class="app-top">
            <div>
                <h1>Dashboard</h1>
                <p>Ringkasan aktivitas bisnis makeup kamu.</p>
            </div>
            
            <a class="notification-dot" href="{{ route('admin.bookings') }}" aria-label="Lihat booking">
                ♧<i></i>
            </a>
        </header>

        @include('partials.flash')

        <div class="stat-grid admin-stat-grid">
            <article class="stat-card">
                <span class="stat-icon">▦</span>
                <div>
                    <small>Total Booking</small>
                    <strong>{{ $totalBookings }}</strong>
                </div>
            </article>

            <article class="stat-card">
                <span class="stat-icon peach">✿</span>
                <div>
                    <small>Layanan</small>
                    <strong>{{ $totalServices }}</strong>
                </div>
            </article>

            <article class="stat-card">
                <span class="stat-icon lavender">♙</span>
                <div>
                    <small>Customer</small>
                    <strong>{{ $totalCustomers }}</strong>
                </div>
            </article>

            <article class="stat-card">
                <span class="stat-icon green">▤</span>
                <div>
                    <small>Total Transaksi</small>
                    <strong class="revenue-stat">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </strong>
                </div>
            </article>
        </div>

        <section class="panel admin-recent-panel">
            <div class="panel-heading">
                <div>
                    <h2>Booking Terbaru</h2>
                </div>
                <a class="text-link" href="{{ route('admin.bookings') }}">Lihat semua</a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal Acara</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ $booking->customer->name ?? 'Customer' }}</strong>
                                </td>
                                <td>{{ $booking->service->name ?? 'Layanan dihapus' }}</td>
                                <td>{{ $booking->event_date->format('d M Y') }}</td>
                                <td>
                                    <span class="status status-{{ strtolower($booking->status) }}">
                                        {{ $booking->status === 'Menunggu' ? 'Menunggu Konfirmasi' : $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    <a class="table-action" href="{{ route('admin.bookings') }}">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    Belum ada booking masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="admin-lower-grid">
            <section class="panel mini-summary">
                <div class="panel-heading">
                    <h2>Ringkasan Status Booking</h2>
                </div>

                <div class="progress-row">
                    <span>Menunggu Konfirmasi</span>
                    <div>
                        <i style="width: {{ $totalBookings ? ($waitingBookings / $totalBookings * 100) : 0 }}%"></i>
                    </div>
                    <strong>{{ $waitingBookings }}</strong>
                </div>

                <div class="progress-row">
                    <span>Dikonfirmasi</span>
                    <div>
                        <i class="bar-pink" style="width: {{ $totalBookings ? ($confirmedBookings / $totalBookings * 100) : 0 }}%"></i>
                    </div>
                    <strong>{{ $confirmedBookings }}</strong>
                </div>

                <div class="progress-row">
                    <span>Selesai</span>
                    <div>
                        <i class="bar-green" style="width: {{ $totalBookings ? ($completedBookings / $totalBookings * 100) : 0 }}%"></i>
                    </div>
                    <strong>{{ $completedBookings }}</strong>
                </div>
            </section>

            <section class="panel quick-actions">
                <div class="panel-heading">
                    <h2>Aksi Cepat</h2>
                </div>
                <div class="quick-action-buttons">
                    <a class="btn btn-primary" href="{{ route('admin.services') }}">Tambah Layanan</a>
                    <a class="btn btn-light" href="{{ route('admin.bookings') }}">Periksa Booking</a>
                    <a class="btn btn-outline" href="{{ route('admin.transactions') }}">Lihat Transaksi</a>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection