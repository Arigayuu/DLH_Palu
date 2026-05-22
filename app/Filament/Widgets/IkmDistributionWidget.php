<?php

namespace App\Filament\Widgets;

use App\Models\IkmResponse;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Reactive;

class IkmDistributionWidget extends Widget
{
    protected string $view = 'filament.widgets.ikm-distribution-widget';

    protected int | string | array $columnSpan = 'full';

    #[Reactive]
    public array $pageFilters = [];

    protected function getViewData(): array
    {
        $year = $this->pageFilters['selectedYear'] ?? date('Y');
        $month = $this->pageFilters['selectedMonth'] ?? 'all';
        $cacheKey = "ikm_distributions_{$year}_{$month}";

        $distributions = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $month) {
            $query = IkmResponse::query();

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            if ($month && $month !== 'all') {
                $query->whereMonth('created_at', $month);
            }

            $selects = [];
            for ($i = 1; $i <= 7; $i++) {
                $key = "indikator_{$i}";
                $selects[] = "SUM(CASE WHEN {$key} = 1 THEN 1 ELSE 0 END) as {$key}_1";
                $selects[] = "SUM(CASE WHEN {$key} = 2 THEN 1 ELSE 0 END) as {$key}_2";
                $selects[] = "SUM(CASE WHEN {$key} = 3 THEN 1 ELSE 0 END) as {$key}_3";
                $selects[] = "SUM(CASE WHEN {$key} = 4 THEN 1 ELSE 0 END) as {$key}_4";
            }

            $dbData = $query->selectRaw(implode(', ', $selects))->first();

            $dist = [];
            for ($i = 1; $i <= 7; $i++) {
                $key = "indikator_{$i}";
                $dist[$key] = [
                    '1' => (int) ($dbData->{"{$key}_1"} ?? 0),
                    '2' => (int) ($dbData->{"{$key}_2"} ?? 0),
                    '3' => (int) ($dbData->{"{$key}_3"} ?? 0),
                    '4' => (int) ($dbData->{"{$key}_4"} ?? 0),
                ];
            }

            return $dist;
        });

        return [
            'distributions' => $distributions,
            'indicatorNames' => [
                'indikator_1' => 'Persyaratan',
                'indikator_2' => 'Prosedur',
                'indikator_3' => 'Waktu Layanan',
                'indikator_4' => 'Biaya/Tarif',
                'indikator_5' => 'Spesifikasi Produk',
                'indikator_6' => 'Kompetensi Petugas',
                'indikator_7' => 'Penanganan Pengaduan',
            ],
        ];
    }
}
