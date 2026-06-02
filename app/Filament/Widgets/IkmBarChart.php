<?php

namespace App\Filament\Widgets;

use App\Models\IkmResponse;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Reactive;

class IkmBarChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Nilai Rata-rata per Unsur Pelayanan';

    protected ?string $maxHeight = '350px';

    #[Reactive]
    public array $pageFilters = [];

    protected function getData(): array
    {
        $year = $this->pageFilters['selectedYear'] ?? date('Y');
        $month = $this->pageFilters['selectedMonth'] ?? 'all';
        $cacheKey = "ikm_bar_chart_{$year}_{$month}";

        $values = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $month) {
            $query = IkmResponse::query();

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            if ($month && $month !== 'all') {
                $query->whereMonth('created_at', $month);
            }

            $data = $query->selectRaw('
                COUNT(*) as total,
                AVG(indikator_1) as avg_1,
                AVG(indikator_2) as avg_2,
                AVG(indikator_3) as avg_3,
                AVG(indikator_4) as avg_4,
                AVG(indikator_5) as avg_5,
                AVG(indikator_6) as avg_6,
                AVG(indikator_7) as avg_7
            ')->first();

            $total = $data->total;

            $v = [];
            for ($i = 1; $i <= 7; $i++) {
                $v[] = $total > 0 ? round($data->{"avg_{$i}"}, 2) : 0;
            }
            return $v;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Indeks Kepuasan',
                    'data' => $values,
                    'backgroundColor' => [
                        'rgba(16,185,129,0.8)',
                        'rgba(20,184,166,0.8)',
                        'rgba(59,130,246,0.8)',
                        'rgba(168,85,247,0.8)',
                        'rgba(245,158,11,0.8)',
                        'rgba(239,68,68,0.8)',
                        'rgba(107,114,128,0.8)',
                    ],
                    'borderColor' => [
                        'rgb(16,185,129)',
                        'rgb(20,184,166)',
                        'rgb(59,130,246)',
                        'rgb(168,85,247)',
                        'rgb(245,158,11)',
                        'rgb(239,68,68)',
                        'rgb(107,114,128)',
                    ],
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                ],
            ],
            'labels' => [
                'Persyaratan',
                'Prosedur',
                'Waktu Layanan',
                'Biaya/Tarif',
                'Spesifikasi Produk',
                'Kompetensi Petugas',
                'Penanganan Pengaduan',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 4,
                    'ticks' => ['stepSize' => 1],
                ],
            ],
            'plugins' => [
                'legend' => ['display' => false],
            ],
        ];
    }
}
