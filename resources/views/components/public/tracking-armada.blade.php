<?php

use Livewire\Component;
use App\Models\GpsVehicleCache;

new class extends Component
{
    public $search = '';
    public bool $filterChanged = false;

    public function updatedSearch()
    {
        $this->filterChanged = true;
    }

    public function getVehicles(): array
    {
        $query = GpsVehicleCache::query()->where('acc', 1);

        if (filled($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $vehicles = $query->get()->toArray();
        $this->js('window.dispatchEvent(new CustomEvent("guest-map-vehicles-updated", { detail: { vehicles: ' . json_encode($vehicles) . ', fitBounds: ' . ($this->filterChanged ? 'true' : 'false') . ' } }))');
        $this->filterChanged = false;
        return $vehicles;
    }

    public function getActiveCount(): int
    {
        return GpsVehicleCache::where('acc', 1)->count();
    }

    public function getLastSync(): ?string
    {
        $latest = GpsVehicleCache::max('updated_at');
        return $latest ? \Carbon\Carbon::parse($latest)->timezone('Asia/Makassar')->translatedFormat('d F Y, H:i') . ' WITA' : null;
    }
};
?>

<div class="space-y-6" wire:poll.30s>
    <style>
        .custom-vehicle-icon { background: transparent !important; border: none !important; box-shadow: none !important; }
        .vehicle-tooltip { font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 6px; }
    </style>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h3 class="font-bold text-slate-800 dark:text-slate-200">Daftar Armada Aktif</h3>
                <span class="flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-full text-xs font-bold">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $this->getActiveCount() }} unit aktif
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Hanya menampilkan kendaraan dengan status mesin menyala (on-duty).</p>
            @if($this->getLastSync())
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display:inline;width:14px;height:14px;vertical-align:middle;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Sinkronisasi terakhir: {{ $this->getLastSync() }}
                </p>
            @endif
        </div>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama armada..." class="w-full md:w-64 px-4 py-2 border border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 text-sm" />
    </div>

    <div class="w-full rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-2 shadow-sm">
        <div wire:ignore
             x-data="{
                 map: null,
                 markers: [],
                 initMap() {
                     this.map = L.map($refs.mapContainer).setView([-0.9, 119.87], 13);
                     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                         attribution: '&copy; OpenStreetMap contributors'
                     }).addTo(this.map);
                 },
                 drawMarkers(vehicleData, fitView = false) {
                     if (!this.map) return;

                     const existingImeis = new Set(this.markers.map(m => m.options.imei));
                     const newImeis = new Set(vehicleData.map(v => v.imei));

                     this.markers = this.markers.filter(m => {
                         if (!newImeis.has(m.options.imei)) {
                             this.map.removeLayer(m);
                             return false;
                         }
                         return true;
                     });

                     vehicleData.forEach(v => {
                         const lat = parseFloat(v.latitude);
                         const lng = parseFloat(v.longitude);
                         if (isNaN(lat) || isNaN(lng)) return;

                         const isTruck = (parseInt(v.veh_type) === 4);
                         const prefix = isTruck ? 'truck' : 'car';
                         const iconUrl = `/assets/tracking/${prefix}_acc_on.png`;

                         const markerHtml = `<div style='width:40px;height:40px;display:flex;align-items:center;justify-content:center;'><img src='${iconUrl}' style='transform:rotate(${v.angle}deg);width:32px;height:32px;transition:transform 0.3s ease;' /></div>`;

                         const customIcon = L.divIcon({
                             html: markerHtml,
                             className: 'custom-vehicle-icon',
                             iconSize: [40, 40],
                             iconAnchor: [20, 20]
                         });

                         const existing = this.markers.find(m => m.options.imei === v.imei);

                         if (existing) {
                             existing.setLatLng([lat, lng]);
                             existing.setIcon(customIcon);
                         } else {
                             const marker = L.marker([lat, lng], { icon: customIcon, imei: v.imei })
                                 .addTo(this.map)
                                 .bindTooltip(v.title, {
                                     permanent: false,
                                     direction: 'top',
                                     offset: [0, -24],
                                     className: 'vehicle-tooltip'
                                 })
                                 .bindPopup(`<div style='min-width:180px;padding:4px;'><p style='font-weight:700;font-size:13px;color:#10b981;margin:0 0 6px;'>${v.title}</p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Kecepatan: ${v.speed} km/h</p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Status: <strong style='color:#10b981'>Aktif Melayani</strong></p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Update: ${v.server_time}</p></div>`);

                             this.markers.push(marker);
                         }
                     });

                     if (fitView && this.markers.length > 0) {
                         const group = new L.featureGroup(this.markers);
                         this.map.fitBounds(group.getBounds().pad(0.1));
                     }
                 }
             }"
             x-on:guest-map-vehicles-updated.window="drawMarkers($event.detail.vehicles, $event.detail.fitBounds)"
             x-init="
                 const boot = () => {
                     initMap();
                     drawMarkers(@js($this->getVehicles()), true);
                 };
                 if (window.L) { boot(); } else {
                     const link = document.createElement('link');
                     link.rel = 'stylesheet';
                     link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                     document.head.appendChild(link);
                     const script = document.createElement('script');
                     script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                     script.onload = () => boot();
                     document.head.appendChild(script);
                 }
             ">
            <div x-ref="mapContainer" style="height: 550px; width: 100%; z-index: 1;" class="rounded-t-2xl"></div>
            
        </div>
        
        <div class="p-4 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 rounded-b-2xl">
            <h4 class="font-bold text-xs text-slate-500 dark:text-slate-400 mb-4 uppercase tracking-wider text-center md:text-left">Legenda Armada Aktif</h4>
            <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                        <img src="/assets/tracking/car_acc_on.png" class="w-7 h-7 object-contain" alt="Pickup">
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Mobil Pickup (Roda 4)</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                        <img src="/assets/tracking/truck_acc_on.png" class="w-7 h-7 object-contain" alt="Dump Truck">
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Dump Truck (Roda 6)</span>
                </div>
            </div>
        </div>
    </div>
</div>