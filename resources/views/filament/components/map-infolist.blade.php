<div class="w-full rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800"
     x-data="{
         initMap() {
             const lat = {{ $getRecord()->latitude }};
             const lng = {{ $getRecord()->longitude }};
             const map = L.map($refs.mapContainer).setView([lat, lng], 15);
             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                 attribution: '&copy; OpenStreetMap contributors'
             }).addTo(map);
             const customIcon = L.icon({
                 iconUrl: '{{ asset('assets/tracking/alarm.png') }}',
                 iconSize: [32, 32],
                 iconAnchor: [16, 32],
                 popupAnchor: [0, -32]
             });
             L.marker([lat, lng], { icon: customIcon })
                 .addTo(map)
                 .bindPopup('<strong>{{ $getRecord()->nomor_tiket }}</strong><br>Kategori: {{ $getRecord()->kategori }}')
                 .openPopup();
         }
     }"
     x-init="
         if (window.L) {
             initMap();
         } else {
             const link = document.createElement('link');
             link.rel = 'stylesheet';
             link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
             document.head.appendChild(link);
             const script = document.createElement('script');
             script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
             script.onload = () => initMap();
             document.head.appendChild(script);
         }
     ">
    <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">Peta Lokasi Laporan</span>
        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $getRecord()->latitude }}, {{ $getRecord()->longitude }}</span>
    </div>
    <div x-ref="mapContainer" style="height: 400px; width: 100%; z-index: 1;"></div>
</div>
