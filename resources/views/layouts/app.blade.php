<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kwitansi Bimbel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-100 min-h-screen print:bg-white">

    <nav class="bg-indigo-700 text-white shadow print:hidden">
        <div class="mx-auto flex max-w-5xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('kwitansi.index') }}" class="min-w-0 truncate text-lg font-semibold">
                {{ config('company.name') }} &mdash; Kwitansi
            </a>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm">
                <a href="{{ route('kwitansi.create') }}"
                   class="rounded-md bg-white px-3 py-1.5 font-medium text-indigo-700 hover:bg-indigo-50">
                    + Buat Kwitansi
                </a>
                <a href="{{ route('settings.company.edit') }}" class="font-medium text-indigo-100 hover:text-white">
                    Pengaturan
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-5xl px-3 py-5 sm:px-4 sm:py-8">
        @if (session('success'))
            <div class="print:hidden mb-4 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
