@extends('layouts.app')

@section('title', 'Booking Layanan')

@section('content')
@if(session('user_id'))
<header class="site-header customer-header">
    <a class="brand" href="{{ route('home') }}">
        <span class="brand-flower">✿</span> Blush & Bloom
    </a>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a class="active" href="{{ route('services.index') }}">Layanan</a>
        <a href="{{ route('dashboard') }}">Booking Saya</a>
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
@else
<header class="site-header">
    <a class="brand" href="{{ route('home') }}">
        <span class="brand-flower">✿</span> Blush & Bloom
    </a>
    <nav>
        <a href="{{ route('home') }}">Beranda</a>
        <a class="active" href="{{ route('services.index') }}">Layanan</a>
    </nav>
    <div class="header-actions">
        <a class="login-link" href="{{ route('login') }}">Login</a>
    </div>
</header>
@endif

<style>
    .bk-breadcrumb { font-size: 12px; color: #9a7b88; margin-bottom: 6px; }
    .bk-required { font-size: 12px; color: #9a7b88; margin: 6px 0 16px; }
    .bk-actions { display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1dde5; padding-top: 18px; }
    .bk-summary-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; padding: 8px 0; border-top: 1px solid #f1dde5; }
    .bk-badge { background: #fff1d6; color: #a86a00; font-size: 12px; padding: 4px 10px; border-radius: 999px; }
    .bk-note { font-size: 12px; color: #9a7b88; margin-top: 10px; }
</style>

<main class="wrap booking-page">
    <div class="bk-breadcrumb">Layanan / Booking</div>

    <div class="booking-layout">
        <section class="panel booking-panel">
            <h1>Booking Layanan</h1>
            <p class="muted">Lengkapi detail acara agar kami bisa menyiapkan riasan terbaik untukmu.</p>

            @include('partials.flash')

            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf

                <div class="form-two">
                    <div class="field">
                        <label>Pilih Layanan *</label>
                        <select name="service_id" id="service_id" required>
                            <option value="">Pilih layanan</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                        data-name="{{ $service->name }}"
                                        data-desc="{{ $service->description }}"
                                        data-price="Rp {{ number_format($service->price, 0, ',', '.') }}"
                                        data-image="{{ $service->image ? asset('storage/' . $service->image) : '' }}"
                                        @selected(old('service_id', optional($selectedService)->id) == $service->id)>
                                    {{ $service->name }} — Rp {{ number_format($service->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Tanggal Acara *</label>
                        <input type="date" name="event_date" min="{{ date('Y-m-d') }}" value="{{ old('event_date') }}" required>
                    </div>
                </div>

                <div class="form-two">
                    <div class="field">
                        <label>Waktu Acara *</label>
                        <input type="time" name="event_time" value="{{ old('event_time') }}" required>
                    </div>
                    <div class="field">
                        <label>Jenis Acara *</label>
                        <select name="event_type" required>
                            <option value="">Pilih jenis acara</option>
                            @foreach(['Pernikahan', 'Wisuda', 'Prewedding', 'Lamaran', 'Pesta', 'Lainnya'] as $type)
                                <option @selected(old('event_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Alamat / Lokasi Acara *</label>
                    <input name="event_location" value="{{ old('event_location') }}" placeholder="Gedung / alamat lengkap" required>
                </div>

                <div class="field">
                    <label>Catatan Tambahan</label>
                    <textarea name="notes" rows="4" placeholder="Contoh: tema warna kebaya, preferensi riasan, atau permintaan khusus">{{ old('notes') }}</textarea>
                </div>

                <p class="bk-required">* wajib diisi</p>

                <div class="bk-actions">
                    <a class="btn btn-outline" href="{{ route('dashboard') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">Kirim Booking</button>
                </div>
            </form>
        </section>

        <aside class="booking-aside">
            <h3>Ringkasan Layanan</h3>
            <div class="booking-art" id="sum-art">
                <span>✿</span><i>✦</i>
            </div>
            <strong id="sum-name">Pilih layanan</strong>
            <p id="sum-desc" class="muted"></p>

            <div class="bk-summary-row">
                <span>Harga mulai dari</span>
                <strong id="sum-price">-</strong>
            </div>
            <div class="bk-summary-row">
                <span>Status awal booking</span>
                <span class="bk-badge">Menunggu Konfirmasi</span>
            </div>
            <p class="bk-note">Booking akan dikonfirmasi oleh MUA.</p>
        </aside>
    </div>
</main>

<script>
    const select = document.getElementById('service_id');
    const defaultArt = document.getElementById('sum-art').innerHTML;

    function updateSummary() {
        const opt = select.options[select.selectedIndex];
        document.getElementById('sum-name').textContent = opt.dataset.name || 'Pilih layanan';
        document.getElementById('sum-desc').textContent = opt.dataset.desc || '';
        document.getElementById('sum-price').textContent = opt.dataset.price || '-';
        const art = document.getElementById('sum-art');
        art.innerHTML = opt.dataset.image
            ? '<img src="' + opt.dataset.image + '" style="width:100%;height:100%;object-fit:cover;border-radius:14px;">'
            : defaultArt;
    }
    select.addEventListener('change', updateSummary);
    updateSummary();
</script>
@endsection