@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
<header class="site-header customer-header">
    <a class="brand" href="{{ route('home') }}">
        <span class="brand-flower">✿</span> Blush & Bloom
    </a>
    <nav>
        <a class="active" href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('services.index') }}">Layanan</a>
        <a href="{{ route('bookings.create') }}">Booking Saya</a>
    </nav>
    <div class="customer-header-actions">
        <span>Hai, {{ session('user_name') }}</span>
        <span class="avatar customer-avatar">{{ strtoupper(substr(session('user_name', 'N'), 0, 1)) }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline btn-small" type="submit">Keluar</button>
        </form>
    </div>
</header>

<main class="customer-main wrap">
    <header class="customer-welcome">
        <div>
            <h1>Halo, {{ session('user_name') }}</h1>
            <p>Ini ringkasan booking makeup kamu.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('bookings.create') }}">Booking Layanan</a>
    </header>

    @include('partials.flash')

    <div class="customer-stats">
        <article class="customer-stat">
            <span>◷</span>
            <div>
                <strong>{{ $bookings->where('status', 'Menunggu')->count() }}</strong>
                <small>Menunggu Konfirmasi</small>
            </div>
        </article>
        <article class="customer-stat">
            <span>♡</span>
            <div>
                <strong>{{ $bookings->where('status', 'Dikonfirmasi')->count() }}</strong>
                <small>Dikonfirmasi</small>
            </div>
        </article>
        <article class="customer-stat">
            <span>★</span>
            <div>
                <strong>{{ $bookings->where('status', 'Selesai')->count() }}</strong>
                <small>Selesai</small>
            </div>
        </article>
    </div>

    <section class="panel customer-bookings-panel">
        <div class="panel-heading">
            <div>
                <h2>Booking Saya</h2>
                <p>Pantau perkembangan booking layanan makeup kamu.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="customer-bookings-table">
                <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Tanggal Acara</th>
                        <th>Jenis Acara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="service-name-cell">
                                <span class="service-small-icon">✿</span>
                                <span><strong>{{ $booking->service->name }}</strong></span>
                            </td>
                            <td>
                                {{ $booking->event_date->translatedFormat('l, d M Y') }}
                                <small>{{ substr($booking->event_time, 0, 5) }}</small>
                            </td>
                            <td>{{ $booking->event_type }}</td>
                            <td>
                                <span class="status status-{{ strtolower($booking->status) }}">
                                    {{ $booking->status === 'Menunggu' ? 'Menunggu Konfirmasi' : $booking->status }}
                                </span>
                            </td>
                            <td>
                                @if($booking->status === 'Menunggu')
                                    <form method="POST" action="{{ route('bookings.destroy', $booking) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action" data-confirm="Batalkan booking ini?">Batalkan</button>
                                    </form>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <span>✿</span>
                                <strong>Belum ada booking</strong>
                                <p>Booking pertama kamu akan muncul di sini.</p>
                                <a class="btn btn-primary btn-small" href="{{ route('services.index') }}">Pilih layanan</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection