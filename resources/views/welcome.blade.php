@extends('layouts.app')

@section('title', 'Beranda - Dinas Lingkungan Hidup Kota Palu')

@section('content')
<div class="space-y-20 pb-16">
    <section class="relative overflow-hidden before:absolute before:top-0 before:start-1/2 before:bg-no-repeat before:bg-top before:bg-cover before:size-full before:-z-[1] before:transform before:-translate-x-1/2 dark:before:bg-[url('https://preline.co/assets/svg/examples-dark/polygon-bg-element.svg')]">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-10">
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-x-2 bg-white border border-slate-200 text-xs text-slate-600 p-2 px-3 rounded-full transition hover:border-slate-300 dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400">
                    Sistem Layanan Publik Digital Terpadu
                    <span class="flex items-center gap-x-1">
                        <span class="border-s border-slate-200 text-brand-600 ps-2 dark:text-brand-500 dark:border-slate-700">Explore</span>
                        <svg class="flex-shrink-0 size-4 text-brand-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </span>
                </span>
            </div>

            <div class="mt-5 max-w-2xl text-center mx-auto">
                <h1 class="block font-bold text-slate-800 text-4xl md:text-5xl lg:text-6xl dark:text-slate-200">
                    Menjaga Palu Tetap
                    <span class="bg-clip-text bg-gradient-to-tl from-brand-600 to-emerald-400 text-transparent">Bersih & Asri</span>
                </h1>
            </div>

            <div class="mt-5 max-w-3xl text-center mx-auto">
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    Sistem Layanan Informasi Publik (SILP) Dinas Lingkungan Hidup Kota Palu. Pantau pergerakan armada pengangkut sampah secara real-time, laporkan permasalahan lingkungan, dan sampaikan kepuasan pelayanan Anda secara transparan.
                </p>
            </div>

            <div class="mt-8 gap-3 flex justify-center">
                <a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-brand-600 to-brand-500 hover:from-brand-600 hover:to-brand-600 border border-transparent text-white text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-brand-600 py-3 px-6 shadow-lg shadow-brand-500/30 transition-all hover:scale-[1.02]" href="/lapor">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    Laporkan Aduan
                </a>
                <a class="inline-flex justify-center items-center gap-x-3 text-center bg-white border border-slate-200 text-slate-800 hover:bg-slate-50 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-slate-300 py-3 px-6 shadow-sm transition-all hover:scale-[1.02] dark:bg-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800" href="/lacak">
                    Lacak Status
                </a>
            </div>
        </div>
    </section>

    <section class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 dark:bg-slate-900 dark:border-slate-700 shadow-sm">
            <div class="grid lg:grid-cols-7 gap-10 lg:gap-16 items-center">
                <div class="lg:col-span-3">
                    <div class="relative rounded-2xl overflow-hidden group shadow-lg">
                        <div class="absolute inset-0 bg-brand-500 mix-blend-multiply opacity-10 group-hover:opacity-0 transition-opacity duration-500"></div>
                        <img class="w-full object-cover rounded-2xl aspect-[4/5]" src="assets/images/foto_kadis.jpeg" alt="Foto Kepala Dinas">
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-900/80 to-transparent p-6">
                            <p class="text-white font-semibold text-lg">Mohamad Arif, S.STP., M.Si</p>
                            <p class="text-brand-300 text-sm">Kepala Dinas Lingkungan Hidup Kota Palu</p>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-4 space-y-6">
                    <div class="inline-block">
                        <h2 class="text-2xl font-bold text-slate-800 sm:text-3xl lg:text-4xl dark:text-slate-200">
                            Komitmen Pelayanan Publik yang Transparan & Cepat
                        </h2>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg">
                        "Dinas Lingkungan Hidup Kota Palu terus berupaya meningkatkan kualitas kebersihan, pengelolaan persampahan, dan pelestarian Ruang Terbuka Hijau. Melalui Sistem Layanan Informasi Publik (SILP) ini, kami wujudkan pelayanan yang lebih cepat, transparan, dan terintegrasi untuk kenyamanan seluruh warga Kota Palu."
                    </p>
                    
                    <div class="grid sm:grid-cols-2 gap-4 mt-8">
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                            <div class="flex items-center gap-x-3">
                                <div class="inline-flex justify-center items-center size-[46px] rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-900/30 dark:text-brand-400">
                                    <svg class="flex-shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div class="grow">
                                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">Gratis</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Tanpa dipungut biaya</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                            <div class="flex items-center gap-x-3">
                                <div class="inline-flex justify-center items-center size-[46px] rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    <svg class="flex-shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div class="grow">
                                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">Real-time</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Pelacakan via GPS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <h2 class="text-3xl font-extrabold tracking-tight dark:text-slate-100">Kategori Pelayanan Pengaduan</h2>
            <p class="text-slate-500 dark:text-slate-400">Kami menangani berbagai keluhan terkait pemeliharaan pohon pelindung di ruang publik kota.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group flex flex-col justify-center bg-white border border-slate-200 shadow-sm rounded-xl p-6 hover:shadow-md transition dark:bg-slate-900 dark:border-slate-700 dark:hover:border-slate-600">
                <div class="size-12 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center rounded-lg font-bold text-xl mb-4">
                    T
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Pohon Tumbang</h3>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    Penanganan darurat untuk pohon yang sudah tumbang dan menghalangi jalan raya atau menimpa fasilitas umum.
                </p>
            </div>

            <div class="group flex flex-col justify-center bg-white border border-slate-200 shadow-sm rounded-xl p-6 hover:shadow-md transition dark:bg-slate-900 dark:border-slate-700 dark:hover:border-slate-600">
                <div class="size-12 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center rounded-lg font-bold text-xl mb-4">
                    R
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Pohon Rawan</h3>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    Pengajuan pemangkasan atau penebangan pohon yang kondisinya lapuk keropos atau miring membahayakan.
                </p>
            </div>

            <div class="group flex flex-col justify-center bg-white border border-slate-200 shadow-sm rounded-xl p-6 hover:shadow-md transition dark:bg-slate-900 dark:border-slate-700 dark:hover:border-slate-600">
                <div class="size-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center rounded-lg font-bold text-xl mb-4">
                    K
                </div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Mengganggu Kabel</h3>
                <p class="mt-2 text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    Pemangkasan dahan pohon pelindung yang telah menjalar masuk ke jalur kabel jaringan tegangan tinggi.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-800 rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -end-24 size-96 bg-brand-600/20 blur-3xl rounded-full"></div>
            
            <div class="text-center max-w-2xl mx-auto space-y-3 relative z-10 mb-10">
                <h2 class="text-3xl font-extrabold tracking-tight text-white">Kesiapan Armada Operasional</h2>
                <p class="text-slate-400">Armada kami siap merespons laporan warga di seluruh penjuru Kota Palu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 group hover:border-brand-500/50 transition">
                    <div class="h-56 overflow-hidden">
                        <img src="assets/images/r4_pickup.jpeg" alt="Armada Pick Up Pengangkut Sampah" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-white mb-1">Armada L300 / Pick Up</h3>
                        <p class="text-sm text-slate-400">Armada roda empat yang digunakan untuk menjangkau pengangkutan sampah di area pemukiman padat dan gang-gang sempit Kota Palu.</p>
                    </div>
                </div>
                
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 group hover:brand-500/50 transition">
                    <div class="h-56 overflow-hidden">
                        <img src="assets/images/r6_truck.jpeg" alt="Armada Truk Pengangkut Sampah" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-white mb-1">Armada Truk (R6)</h3>
                        <p class="text-sm text-slate-400">Armada truk sampah berkapasitas besar untuk memindahkan sampah dari TPS (Tempat Pembuangan Sementara) menuju TPA (Tempat Pemrosesan Akhir).</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 text-center relative z-10">
                <a href="/armada" class="inline-flex items-center gap-x-2 text-brand-400 hover:text-brand-300 font-medium transition">
                    Lihat Peta Pelacakan Armada GPS
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
