@extends('layouts.app')

@section('title', 'Makeup Cantik untuk Momen Spesialmu')

@section('content')
<header class="site-header">
    <a class="brand" href="{{ route('home') }}">
        <span class="brand-flower">✿</span> Blush & Bloom
    </a>
    <nav>
        <a class="active" href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('services.index') }}">Layanan</a>
        <a href="#tentang">Tentang</a>
    </nav>
    <div class="header-actions">
        <a class="login-link" href="{{ route('login') }}">Login</a>
        <a class="btn btn-primary btn-small" href="{{ route('bookings.create') }}">Mulai Booking</a>
    </div>
</header>

<main>
    <section class="hero wrap">
        <div class="hero-copy">
            <span class="eyebrow">
                <span>✿</span> Makeup Artist Profesional
            </span>
            <h1>Makeup Cantik untuk<br><em>Momen Spesialmu</em></h1>
            <p>Dari akad, wisuda, hingga pesta — kami hadir dengan riasan yang menonjolkan kecantikan alami. Pilih layanan, atur jadwal, dan pantau status booking dengan mudah.</p>

            <div class="hero-buttons">
                <a class="btn btn-primary" href="{{ route('services.index') }}">Lihat layanan</a>
                <a class="btn btn-outline" href="{{ route('bookings.create') }}">Mulai Booking</a>
            </div>

            <div class="signature">
                <span></span> Your Beauty, Your Moment
            </div>
        </div>

        <div class="hero-art">
            <div class="art-circle"></div>
            <span class="sparkle s1">✦</span>
            <span class="sparkle s2">✧</span>
            <span class="flower f1">✿</span>
            <span class="flower f2">✿</span>
            <div class="brush"></div>
            <div class="lipstick"><i></i></div>
            <div class="palette">
                <i></i><i></i><i></i><i></i><i></i><i></i>
            </div>
        </div>
    </section>

    <section class="section services-section wrap">
        <div class="section-heading">
            <span class="kicker">LAYANAN UNGGULAN</span>
            <h2>Pilih Layanan yang Pas untuk Acaramu</h2>
            <p>Setiap layanan dikerjakan personal sesuai karakter dan tema acaramu.</p>
        </div>

        <div class="service-grid">
            @forelse($services as $service)
                <article class="service-card">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                             style="width:100%;height:180px;object-fit:cover;border-radius:14px;">
                    @else
                        <div class="service-art tone-{{ $loop->iteration }}">
                            <span>✿</span><i>✦</i>
                        </div>
                    @endif

                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>

                    <div class="service-bottom">
                        <strong>Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                        <a href="{{ route('bookings.create', $service) }}" class="btn btn-primary btn-small">
                            Booking
                        </a>
                    </div>
                </article>
            @empty
                <p>Belum ada layanan aktif.</p>
            @endforelse
        </div>

        <div class="center">
            <a class="btn btn-outline" href="{{ route('services.index') }}">
                Lihat Semua Layanan
            </a>
        </div>
    </section>

    <section class="why-section" id="tentang">
        <div class="wrap">
            <div class="section-heading">
                <h2>Kenapa Blush & Bloom?</h2>
                <p>Pengalaman cantik yang tenang, rapi, dan terpercaya.</p>
            </div>

            <div class="benefit-grid">
                <article>
                    <span>♡</span>
                    <div>
                        <h3>Pelayanan Personal</h3>
                        <p>Diskusi look dan kebutuhanmu agar hasil sesuai harapan.</p>
                    </div>
                </article>

                <article>
                    <span>✧</span>
                    <div>
                        <h3>Pilihan Layanan Lengkap</h3>
                        <p>Dari wisuda hingga pernikahan, tersedia pilihan untuk berbagai acara.</p>
                    </div>
                </article>

                <article>
                    <span>▣</span>
                    <div>
                        <h3>Pemesanan Praktis</h3>
                        <p>Booking dan pantau status pesanan melalui satu sistem.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="cta wrap">
        <div>
            <h2>Siap tampil cantik di hari spesialmu?</h2>
            <p>Booking sekarang dan ciptakan momen terbaikmu.</p>
        </div>
        <a class="btn btn-light" href="{{ route('services.index') }}">
            Mulai Booking →
        </a>
        <span class="cta-flower">✿</span>
    </section>
</main>

<footer class="site-footer">
    <div class="wrap footer-grid">
        <div>
            <a class="brand footer-brand" href="{{ route('home') }}">
                <span class="brand-flower">✿</span> Blush & Bloom
            </a>
            <p>Your beauty, your moment.<br>Makeup terbaik untuk momen spesialmu.</p>
        </div>

        <div>
            <strong>Menu</strong>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('services.index') }}">Layanan</a>
            <a href="#tentang">Tentang</a>
            <a href="{{ route('login') }}">Login</a>
        </div>

        <div>
            <strong>Kontak</strong>
            <a href="mailto:hello@blushbloom.test">hello@blushbloom.test</a>
            <span>+62 812-3456-7890</span>
            <span>Jakarta, Indonesia</span>
        </div>
    </div>

    <div class="wrap copyright">
        © {{ date('Y') }} Blush & Bloom. Dibuat dengan sepenuh hati.
    </div>
</footer>
@endsection