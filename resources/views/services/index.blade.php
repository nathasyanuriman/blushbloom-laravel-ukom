@extends('layouts.app')

@section('title', 'Layanan Makeup')

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
        <a href="{{ route('home') }}#tentang">Tentang</a>
    </nav>
    <div class="header-actions">
        <a class="login-link" href="{{ route('login') }}">Login</a>
        <a class="btn btn-primary btn-small" href="{{ route('bookings.create') }}">Mulai Booking</a>
    </div>
</header>
@endif

<main class="wrap page-main">
    <div class="section-heading">
        <span class="kicker">TEMUKAN LOOK TERBAIKMU</span>
        <h1 class="page-title">Layanan Makeup</h1>
        <p>Pilih layanan yang paling sesuai untuk momen spesialmu.</p>
    </div>

    <div class="service-grid all-services">
        @foreach($services as $service)
            <article class="service-card">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                         style="width:100%;height:180px;object-fit:cover;border-radius:14px;">
                @else
                    <div class="service-art tone-{{ ($loop->iteration - 1) % 3 + 1 }}">
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
        @endforeach
    </div>
</main>

<footer class="simple-footer">
    © {{ date('Y') }} Blush & Bloom · Your Beauty, Your Moment
</footer>
@endsection