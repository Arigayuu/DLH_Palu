<?php

use Livewire\Component;
use App\Models\Laporan;

new class extends Component
{
    public $searchTicket = '';
    public $laporan = null;

    public function search()
    {
        $this->validate([
            'searchTicket' => 'required|string',
        ]);

        $this->laporan = Laporan::with('fotos')
            ->where('nomor_tiket', trim($this->searchTicket))
            ->first();

        if (!$this->laporan) {
            $this->addError('searchTicket', 'Nomor tiket tidak ditemukan.');
        }
    }
};
?>

<div class="space-y-6">
    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl p-6 shadow-sm flex flex-col md:flex-row items-end gap-4 max-w-4xl mx-auto">
        <div class="flex-1 w-full space-y-2">
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-slate-300">Nomor Tiket Laporan</label>
            <input wire:model="searchTicket" type="text" placeholder="Contoh: TK-XXXXXX" class="flex h-10 w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:focus-visible:ring-brand-500 font-mono tracking-widest uppercase" />
            @error('searchTicket') <span class="text-[0.8rem] font-medium text-red-500 block">{{ $message }}</span> @enderror
        </div>
        <button wire:click="search" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-white bg-slate-900 text-slate-50 hover:bg-slate-900/90 h-10 py-2 px-6 w-full md:w-auto dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90 dark:ring-offset-slate-950 whitespace-nowrap">
            Cari Laporan
        </button>
    </div>

    @if ($laporan)
        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl p-6 md:p-8 shadow-sm space-y-8 max-w-4xl mx-auto">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
                <div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-wider uppercase">Nomor Tiket</span>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100 font-mono mt-1">{{ $laporan->nomor_tiket }}</h2>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $badgeColors = [
                            'Menunggu' => 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-100',
                            'Diproses' => 'bg-amber-100 text-amber-900 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                            'Selesai' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                            'Ditolak' => 'bg-red-100 text-red-900 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                        ];
                    @endphp
                    <span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2 dark:border-slate-800 dark:focus:ring-slate-300 {{ $badgeColors[$laporan->status] ?? 'bg-slate-100 text-slate-900 border-slate-200' }}">
                        {{ $laporan->status }}
                    </span>
                </div>
            </div>

            <div class="flex justify-around items-center relative w-full px-2">
                @php
                    $steps = ['Menunggu', 'Diproses', 'Selesai'];
                    $currentIdx = array_search($laporan->status, $steps);
                    if ($laporan->status === 'Ditolak') {
                        $steps = ['Menunggu', 'Ditolak'];
                        $currentIdx = 1;
                    }
                @endphp
                @foreach ($steps as $idx => $step)
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="h-8 w-8 rounded-full flex items-center justify-center font-bold text-xs
                            {{ $idx <= $currentIdx 
                                ? ($laporan->status === 'Ditolak' ? 'bg-red-500 text-white shadow shadow-red-500/20' : 'bg-brand-500 text-white shadow shadow-brand-500/20')
                                : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}">
                            {{ $idx + 1 }}
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider">{{ $step }}</span>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 border-t border-slate-200 dark:border-slate-800 pt-8">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold tracking-tight">Rincian Aduan</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-slate-500 dark:text-slate-400 font-medium">Kategori</span>
                                <span class="text-slate-900 dark:text-slate-100 font-semibold">{{ $laporan->kategori }}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500 dark:text-slate-400 font-medium">Tanggal Masuk</span>
                                <span class="text-slate-900 dark:text-slate-100 font-semibold">{{ $laporan->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="block text-sm text-slate-500 dark:text-slate-400 font-medium">Deskripsi</span>
                            <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed mt-1">{{ $laporan->deskripsi }}</p>
                        </div>
                    </div>

                    @if ($laporan->status === 'Ditolak')
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900 rounded-lg">
                            <span class="block text-sm font-semibold text-red-800 dark:text-red-400">Alasan Penolakan</span>
                            <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ $laporan->alasan_penolakan ?? 'Tidak ada alasan penolakan yang ditulis.' }}</p>
                        </div>
                    @endif

                    @if ($laporan->status === 'Selesai')
                        <div class="space-y-2">
                            <span class="block text-sm text-slate-500 dark:text-slate-400 font-medium">Bukti Foto Selesai</span>
                            <div class="rounded-md overflow-hidden border border-slate-200 dark:border-slate-800 aspect-video relative">
                                <img src="/storage/{{ $laporan->bukti_foto_selesai }}" class="w-full h-full object-cover" />
                            </div>
                        </div>
                    @endif

                    @if ($laporan->fotos->isNotEmpty())
                        <div class="space-y-2">
                            <span class="block text-sm text-slate-500 dark:text-slate-400 font-medium">Foto Lampiran Pengaduan</span>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach ($laporan->fotos as $foto)
                                    <div class="aspect-square rounded-md overflow-hidden border border-slate-200 dark:border-slate-800">
                                        <img src="/storage/{{ $foto->path_foto }}" class="w-full h-full object-cover" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold tracking-tight">Lokasi Peta</h3>
                    <div wire:ignore wire:key="map-{{ $laporan->nomor_tiket }}"
                         x-data="{
                             map: null,
                             initMap() {
                                 const lat = parseFloat(@js($laporan->latitude));
                                 const lng = parseFloat(@js($laporan->longitude));
                                 
                                 if (this.map) {
                                     this.map.remove();
                                 }
                                 
                                 this.map = L.map(this.$refs.mapContainer).setView([lat, lng], 14);
                                 L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                     attribution: '&copy; OpenStreetMap contributors'
                                 }).addTo(this.map);
                                 
                                 L.marker([lat, lng]).addTo(this.map)
                                     .bindPopup('Lokasi Laporan')
                                     .openPopup();
                                     
                                 setTimeout(() => {
                                     this.map.invalidateSize();
                                 }, 250);
                             }
                         }"
                         x-init="
                             setTimeout(() => {
                                 initMap();
                             }, 100);
                         ">
                         <div x-ref="mapContainer" class="w-full h-[300px] border border-slate-200 dark:border-slate-800 rounded-md overflow-hidden z-0 relative"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>