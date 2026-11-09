<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Blush & Bloom') | Blush & Bloom</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @yield('content')

    <script>
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (event) {
            if (!confirm(el.dataset.confirm)) event.preventDefault();
        });
    });

    document.querySelectorAll('[data-modal-open]').forEach(function (button) {
        button.addEventListener('click', function () {
            var modal = document.querySelector(button.dataset.modalOpen);
            if (modal) {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            var modal = button.closest('.modal-overlay');
            if (modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(function (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal-overlay:not(.hidden)').forEach(function (modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            });
        }
    });

    var serviceSearch = document.getElementById('service-search');
    if (serviceSearch) {
        serviceSearch.addEventListener('input', function () {
            var query = serviceSearch.value.toLowerCase();
            document.querySelectorAll('.service-row').forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    }

    var bookingSearch = document.getElementById('booking-search');
    if (bookingSearch) {
        bookingSearch.addEventListener('input', function () {
            var query = bookingSearch.value.toLowerCase();
            document.querySelectorAll('.booking-row').forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    }
    </script>
</body>
</html>