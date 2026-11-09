@extends('layouts.app')

@section('title', 'Kelola Layanan')

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
        <a class="side-link active" href="{{ route('admin.services') }}">
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

    <main class="app-main">
        <header class="app-top">
            <div>
                <span class="kicker">PENGELOLAAN DATA</span>
                <h1>Kelola Layanan</h1>
                <p>Tambah, ubah, dan hapus layanan makeup.</p>
            </div>

            <button type="button" class="btn btn-primary" data-modal-open="#add-service">
                ＋ Tambah Layanan
            </button>
        </header>

        @include('partials.flash')

        @if($errors->any())
            <div class="flash flash-error" style="margin:12px 0;padding:12px 16px;border-radius:12px;background:#fde8ec;color:#a12a45;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="panel service-list-panel">
            <div class="panel-heading service-list-heading">
                <div>
                    <h2>Daftar Layanan</h2>
                    <p>{{ $services->count() }} layanan terdaftar</p>
                </div>

                <input class="service-search" type="search" id="service-search" placeholder="⌕ Cari layanan..." aria-label="Cari layanan">
            </div>

            <div class="table-wrap">
                <table class="service-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr class="service-row">
                                <td class="service-name-cell">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                             style="width:44px;height:44px;object-fit:cover;border-radius:10px;">
                                    @else
                                        <span class="service-small-icon">✿</span>
                                    @endif
                                    <span>
                                        <strong>{{ $service->name }}</strong>
                                        <small>{{ $service->description }}</small>
                                    </span>
                                </td>
                                <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status {{ $service->is_active ? 'status-dikonfirmasi' : 'status-dibatalkan' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="service-actions">
                                        <button type="button" class="table-action edit-action" data-modal-open="#edit-service-{{ $service->id }}">
                                            ✎ Edit
                                        </button>
                                        <button type="button" class="table-action delete-action" data-modal-open="#delete-service-{{ $service->id }}">
                                            ♧ Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    Belum ada layanan. Klik Tambah Layanan untuk mulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

{{-- Modal Tambah Layanan --}}
<div class="modal-overlay hidden" id="add-service" aria-hidden="true">
    <section class="service-modal" role="dialog" aria-modal="true" aria-labelledby="add-service-title">
        <div class="modal-heading">
            <div>
                <h2 id="add-service-title">Tambah Layanan</h2>
                <p>Isi detail layanan makeup yang akan ditawarkan.</p>
            </div>
            <button type="button" class="modal-close" data-modal-close aria-label="Tutup">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.services.store') }}" class="modal-service-form" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label>Nama Layanan *</label>
                <input name="name" required maxlength="120" placeholder="Contoh: Makeup Akad">
            </div>

            <div class="field">
                <label>Harga (Rp) *</label>
                <input name="price" type="number" min="0" required placeholder="Contoh: 1500000">
            </div>

            <div class="field">
                <label>Deskripsi *</label>
                <textarea name="description" required maxlength="500" placeholder="Tuliskan deskripsi singkat layanan..."></textarea>
            </div>

            <div class="field">
                <label>Foto Layanan</label>
                <input name="image" type="file" accept="image/png,image/jpeg">
                <small class="muted">Format JPG, JPEG, atau PNG, maksimal 2 MB.</small>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn btn-light" data-modal-close>Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </section>
</div>

{{-- Modal Edit dan Konfirmasi Hapus untuk Setiap Layanan --}}
@foreach($services as $service)
    <div class="modal-overlay hidden" id="edit-service-{{ $service->id }}" aria-hidden="true">
        <section class="service-modal" role="dialog" aria-modal="true" aria-labelledby="edit-service-title-{{ $service->id }}">
            <div class="modal-heading">
                <div>
                    <h2 id="edit-service-title-{{ $service->id }}">Edit Layanan</h2>
                    <p>Perbarui informasi layanan makeup.</p>
                </div>
                <button type="button" class="modal-close" data-modal-close aria-label="Tutup">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.services.update', $service) }}" class="modal-service-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="field">
                    <label>Nama Layanan *</label>
                    <input name="name" value="{{ $service->name }}" required maxlength="120">
                </div>

                <div class="field">
                    <label>Harga (Rp) *</label>
                    <input name="price" type="number" min="0" value="{{ $service->price }}" required>
                </div>

                <div class="field">
                    <label>Deskripsi *</label>
                    <textarea name="description" required maxlength="500">{{ $service->description }}</textarea>
                </div>

                <div class="field">
                    <label>Foto Layanan</label>
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                             style="width:100%;max-height:140px;object-fit:cover;border-radius:12px;margin-bottom:8px;">
                    @endif
                    <input name="image" type="file" accept="image/png,image/jpeg">
                    <small class="muted">Kosongkan jika tidak ingin mengganti foto.</small>
                </div>

                <label class="active-checkbox">
                    <input type="checkbox" name="is_active" value="1" @checked($service->is_active)> Layanan aktif
                </label>

                <div class="modal-buttons">
                    <button type="button" class="btn btn-light" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </section>
    </div>

    <div class="modal-overlay hidden" id="delete-service-{{ $service->id }}" aria-hidden="true">
        <section class="confirm-modal" role="dialog" aria-modal="true" aria-labelledby="delete-title-{{ $service->id }}">
            <div class="confirm-icon">♧</div>
            <h2 id="delete-title-{{ $service->id }}">Hapus layanan ini?</h2>
            <p>Layanan <strong>“{{ $service->name }}”</strong> akan dihapus permanen dan tidak bisa dikembalikan.</p>

            <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                @csrf
                @method('DELETE')

                <div class="modal-buttons confirm-buttons">
                    <button type="button" class="btn btn-light" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </section>
    </div>
@endforeach
@endsection