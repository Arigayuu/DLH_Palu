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
                    {{-- <img src="assets/images/logo_kementrian.png" alt="Logo Kementrian LHK" class="h-10 w-auto" /> --}}
                    <div class="hidden sm:block border-l border-slate-300 dark:border-slate-700 pl-3">
                        <span class="block text-sm font-extrabold tracking-wider text-slate-800 dark:text-slate-100 uppercase">Dinas Lingkungan Hidup</span>
                        <span class="block text-sm font-semi tracking-wider text-slate-800 dark:text-slate-100 uppercase">Kota Palu</span>
                        {{-- <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium">Portal Layanan & Operasional</span> --}}
                    </div>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-6">
                <a href="/"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Beranda</a>
                <a href="/armada"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Pelacakan Armada</a>
                <a href="/lapor"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Pelaporan Pohon</a>
                <a href="/lacak"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Lacak Pelaporan</a>
                <a href="/survei"
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Penilaian</a>
                <a href=""`
                    class="text-sm font-semibold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Tentang Kami</a>
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

<footer class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8 text-slate-600 dark:text-slate-400 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-12 border-b border-slate-200 dark:border-slate-800">
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="assets/images/logo_kota_palu.png" alt="Logo Kota Palu" class="h-12 w-auto object-contain">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-sm tracking-wide uppercase">DLH Kota Palu</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Dinas Lingkungan Hidup</p>
                    </div>
                </div>
                <p class="text-xs leading-relaxed">
                    Berkomitmen mewujudkan Kota Palu yang bersih, hijau, aman, nyaman, dan berwawasan lingkungan menuju pembangunan berkelanjutan.
                </p>
            </div>

            <div class="space-y-4">
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm tracking-wide uppercase">Layanan Publik</h4>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="/" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Informasi Umum</a>
                    </li>
                    <li>
                        <a href="/armada" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelacakan Armada</a>
                    </li>
                    <li>
                        <a href="/lapor" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelaporan Pohon</a>
                    </li>
                    <li>
                        <a href="/lacak" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelacakan Pelaporan</a>
                    </li>
                    <li>
                        <a href="/survei" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Penilaian Indeks Kepuasan Masyarakat</a>
                    </li>
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm tracking-wide uppercase">Tautan Cepat</h4>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="/" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <a href="/armada" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelacakan Armada</a>
                    </li>
                    <li>
                        <a href="/lapor" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelaporan Pohon</a>
                    </li>
                    <li>
                        <a href="/lacak" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Pelacakan Pelaporan</a>
                    </li>
                    <li>
                        <a href="/survei" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Survei Indeks Kepuasan Masyarakat</a>
                    </li>
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="font-semibold text-slate-900 dark:text-white text-sm tracking-wide uppercase">Hubungi Kami</h4>
                
                <div class="flex items-start gap-2 text-xs text-slate-600 dark:text-slate-400">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        3VXR+26J, Jl. Pipit, Tanamodindi, Kec. Palu Sel., Kota Palu, Sulawesi Tengah 94111
                    </a>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="https://wa.me/6285191512076" target="_blank" rel="noopener noreferrer" 
                        class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white transition-all duration-200" 
                        title="Hubungi via WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397 0 11.973 0c3.184.001 6.177 1.242 8.426 3.496 2.249 2.254 3.487 5.25 3.486 8.438-.003 6.625-5.339 11.973-11.914 11.973-2.01-.001-3.987-.508-5.742-1.474L0 24zm6.587-3.445l.365.217c1.551.92 3.566 1.407 5.626 1.408 5.723 0 10.38-4.632 10.382-10.33a10.231 10.231 0 0 0-3.04-7.34 10.298 10.298 0 0 0-7.34-3.041C6.444 1.473 1.786 6.109 1.783 11.81c-.001 2.155.565 4.256 1.64 6.057l.235.394-.999 3.647 3.731-.978z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/dlhkotapalu" target="_blank" rel="noopener noreferrer"
                        class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-pink-600 hover:text-white dark:hover:bg-pink-600 dark:hover:text-white transition-all duration-200" 
                        title="Kunjungi Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/share/18qHSySQr4/?locale=id_ID" target="_blank" rel="noopener noreferrer"
                        class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-blue-700 hover:text-white dark:hover:bg-blue-700 dark:hover:text-white transition-all duration-200" 
                        title="Kunjungi Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class=" pt-6  border-slate-200 dark:border-slate-800/60 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
            <div>
                &copy; {{ date('Y') }} <span class="font-medium text-slate-700 dark:text-slate-300">Dinas Lingkungan Hidup Kota Palu</span>. Hak Cipta Dilindungi.
            </div>
            <div class="flex items-center gap-4 sm:gap-6 divide-x divide-slate-200 dark:divide-slate-800">
                <a href="/kebijakan-privasi" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Kebijakan Privasi</a>
                <a href="/syarat-ketentuan" class="pl-4 sm:pl-6 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
</footer>

    @livewireScripts
    @yield('scripts')
</body>

</html>