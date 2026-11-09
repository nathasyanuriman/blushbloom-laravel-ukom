@extends('layouts.app')

@section('title', 'Login')

@section('content')
<main class="auth-page">
    <section class="auth-art">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-flower">✿</span> Blush & Bloom
        </a>
        
        <div class="hero-art auth-illustration">
            <div class="art-circle"></div>
            <span class="flower f1">✿</span>
            <span class="flower f2">✿</span>
            <div class="brush"></div>
            <div class="lipstick"><i></i></div>
            <div class="palette">
                <i></i><i></i><i></i><i></i><i></i><i></i>
            </div>
        </div>

        <div>
            <h2>Your Beauty, Your Moment.</h2>
            <p>Make every special moment bloom.</p>
        </div>
    </section>

    <section class="auth-form-wrap">
        <div class="auth-form">
            <a class="back-link" href="{{ route('home') }}">← Kembali ke beranda</a>
            
            <span class="kicker">SELAMAT DATANG KEMBALI</span>
            <h1>Welcome back <em>♡</em></h1>
            <p class="muted">Masuk untuk melanjutkan perjalanan cantikmu.</p>

            @include('partials.flash')

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
                
                <div class="form-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <span class="muted small">Minimal 8 karakter</span>
                </div>
                
                <button class="btn btn-primary full" type="submit">
                    Masuk ke Akun →
                </button>
            </form>

            <p class="auth-switch">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </section>
</main>
@endsection