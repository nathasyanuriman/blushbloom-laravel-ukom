@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<header class="site-header customer-header">
    <a class="brand" href="{{ route('home') }}">
        <span class="brand-flower">✿</span> Blush & Bloom
    </a>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('services.index') }}">Layanan</a>
        <a class="active" href="{{ route('dashboard') }}">Booking Saya</a>
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

<style>
    .pay-method { display:flex; gap:10px; margin:6px 0 14px; }
    .pay-method label { flex:1; display:flex; align-items:center; gap:8px; padding:12px; border:1px solid #eadde2; border-radius:10px; cursor:pointer; font-size:12px; margin:0; }
    .pay-method input { accent-color:#d97998; width:auto; }
    .qris-box { text-align:center; padding:14px; border:1px dashed #e7c8d3; border-radius:12px; margin-bottom:12px; }
    .qris-box img { max-width:220px; width:100%; }
    .qris-placeholder { width:200px; height:200px; margin:0 auto; display:grid; place-items:center; background:#f6dce5; border-radius:12px; color:#b75e80; font-weight:700; letter-spacing:2px; }
    .pay-row { display:flex; justify-content:space-between; font-size:13px; padding:8px 0; border-top:1px solid #f1dde5; }
</style>

<main class="wrap booking-page">
    <div class="bk-breadcrumb" style="font-size:12px;color:#9a7b88;margin-bottom:6px;">Booking Saya / Pembayaran</div>

    <div class="booking-layout">
        <section class="panel booking-panel">
            <h1>Pembayaran</h1>
            <p class="muted">Pilih cara pembayaran untuk booking kamu.</p>

            @if($errors->any())
                <div class="flash error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('bookings.pay.store', $booking) }}" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label>Metode Pembayaran *</label>
                    <div class="pay-method">
                        <label><input type="radio" name="payment_method" value="QRIS" checked> QRIS</label>
                        <label><input type="radio" name="payment_method" value="Tunai"> Tunai (cash)</label>
                    </div>
                </div>

                <div id="box-qris">
                    <div class="qris-box">
                        @php $qrisFile = glob(public_path('img/qris.*')); @endphp
                        @if(!empty($qrisFile))
                            <img src="{{ asset('img/' . basename($qrisFile[0])) }}" alt="QRIS Blush & Bloom">
                        @else
                            <div class="qris-placeholder">QRIS</div>
                        @endif
                        <p class="muted">Scan QRIS, bayar sebesar <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>, lalu upload bukti di bawah.</p>
                    </div>

                    <div class="field">
                        <label>Upload Bukti Pembayaran *</label>
                        <input type="file" name="payment_proof" accept="image/png,image/jpeg">
                        <small class="muted">Format JPG atau PNG, maksimal 2 MB.</small>
                    </div>
                </div>

                <div id="box-tunai" class="hidden">
                    <p class="muted">Kamu memilih bayar tunai. Silakan bayar langsung ke MUA sebesar <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>. Admin akan menandai lunas setelah uang diterima.</p>
                </div>

                <div class="bk-actions" style="display:flex;justify-content:flex-end;gap:12px;margin-top:18px;">
                    <a class="btn btn-outline" href="{{ route('dashboard') }}">Batal</a>
                    <button class="btn btn-primary" type="submit">Kirim Pembayaran</button>
                </div>
            </form>
        </section>

        <aside class="booking-aside">
            <h3>Ringkasan Booking</h3>
            @if($booking->service && $booking->service->image)
                <img src="{{ asset('storage/' . $booking->service->image) }}" alt="{{ $booking->service->name }}"
                     style="width:100%;height:150px;object-fit:cover;border-radius:12px;">
            @else
                <div class="booking-art"><span>✿</span><i>✦</i></div>
            @endif
            <strong style="display:block;margin-top:12px;">{{ $booking->service->name ?? 'Layanan' }}</strong>
            <p class="muted">{{ $booking->event_date->translatedFormat('l, d M Y') }}, {{ substr($booking->event_time, 0, 5) }}</p>

            <div class="pay-row"><span>Total</span><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></div>
            <div class="pay-row"><span>Status pembayaran</span><span>{{ $booking->payment_status }}</span></div>
        </aside>
    </div>
</main>

<script>
    const radios = document.querySelectorAll('input[name="payment_method"]');
    function togglePay() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        document.getElementById('box-qris').classList.toggle('hidden', method !== 'QRIS');
        document.getElementById('box-tunai').classList.toggle('hidden', method !== 'Tunai');
    }
    radios.forEach(r => r.addEventListener('change', togglePay));
    togglePay();
</script>
@endsection