<?php

namespace App\Filament\Widgets;

use App\Models\GpsVehicleCache;
use Filament\Widgets\Widget;
use Livewire\Attributes\Reactive;

class TrackingMapWidget extends Widget
{
    protected string $view = 'filament.widgets.tracking-map-widget';

    protected int | string | array $columnSpan = 'full';

    #[Reactive]
    public array $pageFilters = [];

    public array $vehicles = [];
    public bool $fitBounds = false;
    public string $lastFilterHash = '';

    public function mount(): void
    {
        $this->vehicles = $this->fetchVehicles();
        $this->lastFilterHash = md5(json_encode($this->pageFilters));
    }

    private function fetchVehicles(): array
    {
        $search = $this->pageFilters['search'] ?? '';
        $statusFilter = $this->pageFilters['statusFilter'] ?? 'all';

        $query = GpsVehicleCache::query();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('imei', 'like', '%' . $search . '%');
            });
        }

        if ($statusFilter === 'aktif') {
            $query->where('acc', 1);
        } elseif ($statusFilter === 'parkir') {
            $query->where('acc', 0);
        }

        return $query->get()->toArray();
    }

    protected function getViewData(): array
    {
        $latest = GpsVehicleCache::max('updated_at');
        $lastSync = $latest ? \Carbon\Carbon::parse($latest)->timezone('Asia/Makassar')->translatedFormat('d F Y, H:i') . ' WITA' : null;

        $hash = md5(json_encode($this->pageFilters));
        if ($hash !== $this->lastFilterHash) {
            $this->fitBounds = true;
            $this->lastFilterHash = $hash;
        }

        $this->vehicles = $this->fetchVehicles();
        
        $fitBounds = $this->fitBounds;
        $this->fitBounds = false;

        return [
            'vehicles' => $this->vehicles,
            'lastSync' => $lastSync,
            'fitBounds' => $fitBounds,
        ];
    }
}
