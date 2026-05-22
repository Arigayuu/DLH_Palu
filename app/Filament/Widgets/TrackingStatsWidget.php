<?php

namespace App\Filament\Widgets;

use App\Models\GpsVehicleCache;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class TrackingStatsWidget extends BaseWidget
{
    protected ?string $pollingInterval = null;

    #[Reactive]
    public array $pageFilters = [];

    protected function getStats(): array
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

        $total = (clone $query)->count();
        $aktif = (clone $query)->where('acc', 1)->count();
        $parkir = (clone $query)->where('acc', 0)->count();

        return [
            Stat::make('Total Armada', $total)
                ->description('Seluruh armada DLH')
                ->descriptionIcon('heroicon-m-truck')
                ->color('primary'),
            Stat::make('Aktif (Mesin On)', $aktif)
                ->description('Armada sedang aktif')
                ->descriptionIcon('heroicon-m-play')
                ->color('success'),
            Stat::make('Parkir (Mesin Off)', $parkir)
                ->description('Armada sedang parkir')
                ->descriptionIcon('heroicon-m-pause')
                ->color('gray'),
        ];
    }
}
