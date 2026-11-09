@extends('layouts.app')

@section('title', 'Booking Admin')

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
            ✿ Kelola Layanan
        </a>
        <a class="side-link active" href="{{ route('admin.bookings') }}">
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
                <h1>Booking</h1>
                <p>Periksa pemesanan dan perbarui statusnya.</p>
            </div>

            <a class="notification-dot" href="{{ route('admin.dashboard') }}" aria-label="Kembali ke dashboard">
                ‹
            </a>
        </header>

        @include('partials.flash')

        <div class="booking-filter-area">
            <input type="search" id="booking-search" class="service-search" placeholder="⌕ Cari customer...">

            <div class="booking-count-pills">
                <span>Semua {{ $bookings->count() }}</span>
                <span>Menunggu {{ $bookings->where('status', 'Menunggu')->count() }}</span>
                <span>Dikonfirmasi {{ $bookings->where('status', 'Dikonfirmasi')->count() }}</span>
                <span>Selesai {{ $bookings->where('status', 'Selesai')->count() }}</span>
            </div>
        </div>

        <div class="booking-admin-layout">
            <section class="panel booking-list-panel">
                <div class="table-wrap">
                    <table class="booking-admin-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="booking-table-body">
                            @forelse($bookings as $booking)
                                <tr
                                    class="booking-row"
                                    tabindex="0"
                                    data-customer="{{ $booking->customer->name ?? 'Customer' }}"
                                    data-email="{{ $booking->customer->email ?? '-' }}"
                                    data-service="{{ $booking->service->name ?? 'Layanan dihapus' }}"
                                    data-date="{{ $booking->event_date->format('d M Y') }}"
                                    data-time="{{ substr($booking->event_time, 0, 5) }}"
                                    data-type="{{ $booking->event_type }}"
                                    data-location="{{ $booking->event_location }}"
                                    data-notes="{{ $booking->notes ?? '-' }}"
                                    data-status="{{ $booking->status }}"
                                    data-update-url="{{ route('admin.bookings.update', $booking) }}"
                                >
                                    <td>
                                        <strong>{{ $booking->customer->name ?? 'Customer' }}</strong>
                                    </td>
                                    <td>{{ $booking->service->name ?? 'Layanan dihapus' }}</td>
                                    <td>{{ $booking->event_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="status status-{{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        Belum ada booking masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="panel booking-detail-panel">
                <h2>Detail Booking</h2>

                <div id="booking-empty" class="booking-empty">
                    <p>Pilih salah satu booking untuk melihat detailnya.</p>
                </div>

                <div id="booking-detail-content" class="hidden">
                    <div class="detail-status-area">
                        <span id="detail-status" class="status"></span>
                    </div>

                    <div class="detail-item">
                        <small>Customer</small>
                        <strong id="detail-customer">-</strong>
                        <span id="detail-email">-</span>
                    </div>

                    <div class="detail-item">
                        <small>Layanan</small>
                        <strong id="detail-service">-</strong>
                    </div>

                    <div class="detail-item">
                        <small>Tanggal Acara</small>
                        <strong id="detail-date">-</strong>
                    </div>

                    <div class="detail-item">
                        <small>Jenis Acara</small>
                        <strong id="detail-type">-</strong>
                    </div>

                    <div class="detail-item">
                        <small>Lokasi</small>
                        <strong id="detail-location">-</strong>
                    </div>

                    <div class="detail-item">
                        <small>Catatan</small>
                        <strong id="detail-notes">-</strong>
                    </div>

                    <div class="detail-status-update">
                        <small>Ubah Status</small>

                        <form method="POST" id="booking-status-form">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="status" id="booking-status-input">

                            <div class="detail-actions">
                                <button type="button" class="btn btn-primary" id="confirm-booking">
                                    Konfirmasi
                                </button>
                                <button type="button" class="btn btn-light" id="finish-booking">
                                    Selesai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</div>

<style>
.booking-filter-area {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
}

.booking-count-pills {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.booking-count-pills span {
    padding: 7px 12px;
    border: 1px solid #f0dce3;
    border-radius: 20px;
    background: #fff;
    color: #8d7580;
    font-size: 11px;
}

.booking-admin-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 270px;
    gap: 16px;
    align-items: stretch;
}

.booking-list-panel {
    min-width: 0;
    padding: 14px;
}

.booking-admin-table {
    width: 100%;
    border-collapse: collapse;
}

.booking-admin-table thead {
    background: #faedf1;
}

.booking-admin-table th {
    padding: 12px 10px;
    color: #8d7580;
    font-size: 11px;
    text-align: left;
}

.booking-admin-table td {
    padding: 15px 10px;
    border-bottom: 1px solid #f4e8ec;
    color: #604c55;
    font-size: 11px;
}

.booking-admin-table tbody tr.booking-row {
    cursor: pointer;
    transition: background 0.2s;
}

.booking-admin-table tbody tr.booking-row:hover {
    background: #fff6f8;
}

.booking-admin-table tbody tr.booking-row.selected {
    background: #fceaf0;
    box-shadow: inset 3px 0 #d97998;
}

.booking-admin-table tbody tr:focus-visible {
    outline: 2px solid #d97998;
    outline-offset: -2px;
}

.booking-detail-panel {
    padding: 20px;
    border-radius: 14px;
    min-width: 0;
}

.booking-detail-panel h2 {
    margin: 0 0 14px;
    color: #402b35;
    font-size: 16px;
}

.booking-empty {
    color: #8d7580;
    font-size: 12px;
    line-height: 1.6;
}

.detail-status-area {
    margin-bottom: 18px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 15px;
}

.detail-item small,
.detail-status-update small {
    color: #8d7580;
    font-size: 10px;
}

.detail-item strong {
    color: #402b35;
    font-size: 12px;
    font-weight: 500;
    overflow-wrap: anywhere;
}

.detail-item span {
    color: #8d7580;
    font-size: 10px;
}

.detail-status-update {
    border-top: 1px solid #f0dce3;
    padding-top: 15px;
    margin-top: 18px;
}

.detail-actions {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.detail-actions button {
    flex: 1;
    padding: 9px 5px;
    font-size: 10px;
}

.detail-actions button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.booking-row[hidden] {
    display: none;
}

@media (max-width: 900px) {
    .booking-admin-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.booking-row');
    const empty = document.getElementById('booking-empty');
    const detail = document.getElementById('booking-detail-content');
    const form = document.getElementById('booking-status-form');
    const statusInput = document.getElementById('booking-status-input');
    const confirmButton = document.getElementById('confirm-booking');
    const finishButton = document.getElementById('finish-booking');
    const searchInput = document.getElementById('booking-search');

    function selectBooking(row) {
        rows.forEach(item => item.classList.remove('selected'));
        row.classList.add('selected');

        document.getElementById('detail-customer').textContent = row.dataset.customer;
        document.getElementById('detail-email').textContent = row.dataset.email;
        document.getElementById('detail-service').textContent = row.dataset.service;
        document.getElementById('detail-date').textContent = row.dataset.date + ', ' + row.dataset.time;
        document.getElementById('detail-type').textContent = row.dataset.type;
        document.getElementById('detail-location').textContent = row.dataset.location;
        document.getElementById('detail-notes').textContent = row.dataset.notes || '-';

        const status = document.getElementById('detail-status');
        status.textContent = row.dataset.status;
        status.className = 'status status-' + row.dataset.status.toLowerCase();
        form.action = row.dataset.updateUrl;

        empty.classList.add('hidden');
        detail.classList.remove('hidden');

        confirmButton.disabled = row.dataset.status !== 'Menunggu';
        finishButton.disabled = row.dataset.status !== 'Dikonfirmasi';
    }

    rows.forEach(row => {
        row.addEventListener('click', () => selectBooking(row));
        row.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                selectBooking(row);
            }
        });
    });

    confirmButton.addEventListener('click', () => {
        if (form.action && !confirmButton.disabled) {
            statusInput.value = 'Dikonfirmasi';
            form.submit();
        }
    });

    finishButton.addEventListener('click', () => {
        if (form.action && !finishButton.disabled) {
            statusInput.value = 'Selesai';
            form.submit();
        }
    });

    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const customer = row.dataset.customer.toLowerCase();
            const service = row.dataset.service.toLowerCase();
            row.hidden = !customer.includes(keyword) && !service.includes(keyword);
        });

        const selectedRow = document.querySelector('.booking-row.selected');
        if (selectedRow && selectedRow.hidden) {
            empty.classList.remove('hidden');
            detail.classList.add('hidden');
        }
    });

    if (rows.length > 0) {
        selectBooking(rows[0]);
    }
});
</script>
@endsection