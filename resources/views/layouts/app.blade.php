<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kwitansi Bimbel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-slate-100 min-h-screen">

    <nav class="bg-indigo-700 text-white shadow no-print">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('kwitansi.index') }}" class="font-semibold text-lg">
                {{ config('company.name') }} &mdash; Kwitansi
            </a>
            <a href="{{ route('kwitansi.create') }}"
               class="bg-white text-indigo-700 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-indigo-50">
                + Buat Kwitansi
            </a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="no-print mb-4 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</body>
</html>
