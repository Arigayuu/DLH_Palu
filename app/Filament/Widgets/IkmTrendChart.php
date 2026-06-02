<?php

namespace App\Filament\Widgets;

use App\Models\IkmResponse;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Reactive;

class IkmTrendChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Tren Indeks Kepuasan Masyarakat Bulanan';

    protected ?string $maxHeight = '350px';

    #[Reactive]
    public array $pageFilters = [];

    protected function getData(): array
    {
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $year = $this->pageFilters['selectedYear'] ?? date('Y');
        $cacheKey = "ikm_trend_chart_{$year}";

        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $monthNames) {
            $responses = IkmResponse::query()
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total, AVG(indikator_1) as i1, AVG(indikator_2) as i2, AVG(indikator_3) as i3, AVG(indikator_4) as i4, AVG(indikator_5) as i5, AVG(indikator_6) as i6, AVG(indikator_7) as i7')
                ->whereYear('created_at', $year)
                ->groupByRaw('MONTH(created_at)')
                ->get()
                ->keyBy('month');

            $labels = [];
            $values = [];
            $counts = [];

            for ($m = 1; $m <= 12; $m++) {
                $monthData = $responses->get($m);
                
                $total = $monthData ? $monthData->total : 0;
                $avg = 0;

                if ($total > 0) {
                    $sum = $monthData->i1 + $monthData->i2 + $monthData->i3 + $monthData->i4 + $monthData->i5 + $monthData->i6 + $monthData->i7;
                    $avg = round($sum / 7, 2);
                }

                $labels[] = $monthNames[$m];
                $values[] = $avg;
                $counts[] = $total;
            }
            
            return compact('labels', 'values', 'counts');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata IKM',
                    'data' => $data['values'],
                    'borderColor' => 'rgb(16,185,129)',
                    'backgroundColor' => 'rgba(16,185,129,0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => 'rgb(16,185,129)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ],
                [
                    'label' => 'Jumlah Responden',
                    'data' => $data['counts'],
                    'borderColor' => 'rgb(99,102,241)',
                    'backgroundColor' => 'rgba(99,102,241,0.08)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => 'rgb(99,102,241)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 4,
                    'ticks' => ['stepSize' => 1],
                    'title' => [
                        'display' => true,
                        'text' => 'Indeks IKM',
                    ],
                ],
                'y1' => [
                    'position' => 'right',
                    'beginAtZero' => true,
                    'grid' => ['drawOnChartArea' => false],
                    'ticks' => ['precision' => 0],
                    'title' => [
                        'display' => true,
                        'text' => 'Responden',
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
        ];
    }
}
