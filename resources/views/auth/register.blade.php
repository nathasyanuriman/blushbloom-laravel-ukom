@extends('layouts.app')

@section('title', 'Daftar Akun')

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
            <p>Mulai rencanakan momen spesialmu bersama kami.</p>
        </div>
    </section>

    <section class="auth-form-wrap">
        <div class="auth-form">
            <a class="back-link" href="{{ route('home') }}">← Kembali ke beranda</a>
            
            <span class="kicker">GABUNG BERSAMA KAMI</span>
            <h1>Buat akun <em>♡</em></h1>
            <p class="muted">Isi data singkat di bawah untuk mulai booking.</p>

            @include('partials.flash')

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                
                <label>Nama lengkap</label>
                <input name="name" value="{{ old('name') }}" placeholder="Nama kamu" required>
                
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                
                <label>Nomor telepon <span class="muted">(opsional)</span></label>
                <input name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                
                <label>Konfirmasi password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                
                <button class="btn btn-primary full" type="submit">
                    Buat Akun →
                </button>
            </form>

            <p class="auth-switch">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </section>
</main>
@endsection