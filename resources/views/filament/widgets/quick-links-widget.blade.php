<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Akses Cepat
        </x-slot>
        <x-slot name="description">
            Navigasi cepat ke modul-modul penting.
        </x-slot>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <x-filament::button
                href="/admin/dashboard-ikm"
                tag="a"
                color="primary"
                icon="heroicon-m-chart-bar"
                size="md"
                class="w-full justify-center"
            >
                Dashboard IKM
            </x-filament::button>

            <x-filament::button
                href="/admin/tracking-armada"
                tag="a"
                color="success"
                icon="heroicon-m-map"
                size="md"
                class="w-full justify-center"
            >
                Lacak Armada
            </x-filament::button>

            <x-filament::button
                href="/admin/laporans"
                tag="a"
                color="warning"
                icon="heroicon-m-document-text"
                size="md"
                class="w-full justify-center"
            >
                Kelola Laporan
            </x-filament::button>

            <x-filament::button
                href="/admin/ikm-responses"
                tag="a"
                color="info"
                icon="heroicon-m-users"
                size="md"
                class="w-full justify-center"
            >
                Data Responden
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
