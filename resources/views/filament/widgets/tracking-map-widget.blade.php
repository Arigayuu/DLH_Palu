<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Peta Lokasi Armada
        </x-slot>
        <x-slot name="description">
            @if($lastSync)
                Sinkronisasi terakhir: {{ $lastSync }}
            @endif
        </x-slot>

        <style>
            .custom-vehicle-icon { background: transparent !important; border: none !important; box-shadow: none !important; }
            .vehicle-tooltip { font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 6px; }
        </style>

        <div class="w-full rounded-2xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div wire:poll.30s wire:key="poll-trigger-{{ $this->getId() }}"></div>
            
            <div id="vehicles-data-{{ $this->getId() }}" wire:key="vehicles-data-{{ $this->getId() }}" class="hidden" data-vehicles='@json($vehicles)' data-fit='@json($fitBounds)'></div>

            <div wire:ignore id="map-wrapper-{{ $this->getId() }}"
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
                             const iconName = (parseInt(v.acc) === 1) ? '_acc_on.png' : '_parking.png';
                             const iconUrl = `/assets/tracking/${prefix}${iconName}`;

                             const markerHtml = `<div style='width:40px;height:40px;display:flex;align-items:center;justify-content:center;'><img src='${iconUrl}' style='transform:rotate(${v.angle}deg);width:32px;height:32px;transition:transform 0.3s ease;' /></div>`;

                             const customIcon = L.divIcon({
                                 html: markerHtml,
                                 className: 'custom-vehicle-icon',
                                 iconSize: [40, 40],
                                 iconAnchor: [20, 20]
                             });

                             const statusLabel = parseInt(v.acc) === 1 ? 'Aktif' : 'Parkir';
                             const statusColor = parseInt(v.acc) === 1 ? '#10b981' : '#94a3b8';

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
                                     .bindPopup(`<div style='min-width:200px;padding:4px;'><p style='font-weight:700;font-size:13px;color:${statusColor};margin:0 0 6px;'>${v.title}</p><p style='font-size:11px;color:#64748b;margin:2px 0;'>IMEI: ${v.imei}</p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Kecepatan: ${v.speed} km/h</p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Status: <strong style='color:${statusColor}'>${statusLabel}</strong></p><p style='font-size:11px;color:#64748b;margin:2px 0;'>Waktu Server: ${v.server_time}</p></div>`);

                                 this.markers.push(marker);
                             }
                         });

                         if (fitView && this.markers.length > 0) {
                             const group = new L.featureGroup(this.markers);
                             this.map.fitBounds(group.getBounds().pad(0.1));
                         }
                     }
                 }"
                 x-init="
                     const boot = () => {
                         initMap();
                         drawMarkers(@js($vehicles), true);
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

                     const widgetId = @js($this->getId());
                     let debounceTimer = null;

                     Livewire.hook('commit', ({ component, succeed }) => {
                         succeed(() => {
                             if (component.id !== widgetId) return;

                             if (debounceTimer) clearTimeout(debounceTimer);

                             debounceTimer = setTimeout(() => {
                                 const dataEl = document.getElementById('vehicles-data-' + widgetId);
                                 const wrapperEl = document.getElementById('map-wrapper-' + widgetId);
                                 
                                 if (!dataEl || !wrapperEl) return;

                                 try {
                                     const newVehicles = JSON.parse(dataEl.getAttribute('data-vehicles'));
                                     const shouldFit = dataEl.getAttribute('data-fit') === 'true';
                                     if (typeof Alpine !== 'undefined') {
                                         const alpineData = Alpine.$data(wrapperEl);
                                         if (alpineData && alpineData.drawMarkers) {
                                             alpineData.drawMarkers(newVehicles, shouldFit);
                                         }
                                     }
                                 } catch (e) {
                                     console.error('Error updating map markers:', e);
                                 }
                             }, 300);
                         });
                     });
                 ">
                <div x-ref="mapContainer" style="height: 600px; width: 100%; z-index: 1;"></div>
            </div>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
