<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Operasional DLH Kota Palu')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @livewireStyles
    @yield('styles')
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col antialiased">
    <header x-data="{ mobileMenuOpen: false }"
        class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200/50 dark:border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-3">
                    <img src="assets/images/logo_kota_palu.png" alt="Logo Kota Palu" class="h-10 w-auto" />
                    <img src="assets/images/logo_kementrian.png" alt="Logo Kementrian LHK" class="h-10 w-auto" />
                    <div class="hidden sm:block border-l border-slate-300 dark:border-slate-700 pl-3">
                        <span class="block text-sm font-extrabold tracking-wider text-slate-800 dark:text-slate-100 uppercase">DLH Kota Palu</span>
                        <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium">Portal Layanan & Operasional</span>
                    </div>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-6">
                <a href="/"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Beranda</a>
                <a href="/lapor"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Lapor
                    Pohon</a>
                <a href="/lacak"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Lacak
                    Laporan</a>
                <a href="/survei"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Survei
                    IKM</a>
                <a href="/armada"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Pelacakan
                    Armada</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/admin/login"
                    class="hidden md:inline-block px-4 py-2 text-xs font-bold uppercase tracking-wider bg-brand-600 hover:bg-brand-700 text-white rounded-lg transition-colors shadow-sm shadow-brand-500/20">
                    Portal Admin
                </a>
                
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-slate-200 bg-white text-slate-800 shadow-sm hover:bg-slate-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-slate-700 dark:text-white dark:hover:bg-white/10">
                    <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!mobileMenuOpen"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                    <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="mobileMenuOpen" style="display: none;"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900" style="display: none;">
            <div class="flex flex-col px-4 pt-2 pb-4 space-y-1">
                <a href="/" class="px-3 py-2 rounded-md text-base font-semibold text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Beranda</a>
                <a href="/lapor" class="px-3 py-2 rounded-md text-base font-semibold text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Lapor Pohon</a>
                <a href="/lacak" class="px-3 py-2 rounded-md text-base font-semibold text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Lacak Laporan</a>
                <a href="/survei" class="px-3 py-2 rounded-md text-base font-semibold text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Survei IKM</a>
                <a href="/armada" class="px-3 py-2 rounded-md text-base font-semibold text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Pelacakan Armada</a>
                <a href="/admin/login" class="mt-4 px-3 py-2 rounded-md text-base font-bold text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-900/20">Portal Admin</a>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-8">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500 dark:text-slate-400">&copy; {{ date('Y') }} Dinas Lingkungan Hidup Kota
                Palu. Hak Cipta Dilindungi.</p>
            <div class="flex items-center gap-6">
                <a href="/" class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">Kebijakan
                    Privasi</a>
                <a href="/" class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">Syarat &
                    Ketentuan</a>
            </div>
        </div>
    </footer>

    @livewireScripts
    @yield('scripts')
</body>

</html>