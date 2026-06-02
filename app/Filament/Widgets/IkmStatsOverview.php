<?php

namespace App\Filament\Widgets;

use App\Models\IkmResponse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Reactive;

class IkmStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = null;

    #[Reactive]
    public array $pageFilters = [];

    protected function getStats(): array
    {
        $year = $this->pageFilters['selectedYear'] ?? date('Y');
        $month = $this->pageFilters['selectedMonth'] ?? 'all';
        $cacheKey = "ikm_stats_{$year}_{$month}";

        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($year, $month) {
            $query = IkmResponse::query();

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            if ($month && $month !== 'all') {
                $query->whereMonth('created_at', $month);
            }

            $dbData = $query->selectRaw('
                COUNT(*) as total,
                AVG(indikator_1) as avg_1,
                AVG(indikator_2) as avg_2,
                AVG(indikator_3) as avg_3,
                AVG(indikator_4) as avg_4,
                AVG(indikator_5) as avg_5,
                AVG(indikator_6) as avg_6,
                AVG(indikator_7) as avg_7
            ')->first();

            $total = $dbData->total;

            $indicators = [];
            for ($i = 1; $i <= 7; $i++) {
                $indicators["indikator_{$i}"] = $total > 0 ? round($dbData->{"avg_{$i}"}, 2) : 0;
            }

            $overall = $total > 0 ? round(array_sum($indicators) / 7, 2) : 0;
            $percentage = number_format($overall * 25, 2);

            $grade = 'D';
            $gradeColor = 'danger';
            $gradeDesc = 'Tidak Baik';
            if ($overall >= 3.26) {
                $grade = 'A';
                $gradeColor = 'success';
                $gradeDesc = 'Sangat Baik';
            } elseif ($overall >= 2.51) {
                $grade = 'B';
                $gradeColor = 'success';
                $gradeDesc = 'Baik';
            } elseif ($overall >= 1.76) {
                $grade = 'C';
                $gradeColor = 'warning';
                $gradeDesc = 'Kurang Baik';
            }

            return compact('total', 'overall', 'percentage', 'grade', 'gradeColor', 'gradeDesc');
        });

        return [
            Stat::make('Total Responden', $data['total'])
                ->description('Masyarakat berpartisipasi')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Nilai Indeks IKM', number_format($data['overall'], 2))
                ->description('Skala Maksimum 4.00')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Mutu Pelayanan', "Nilai {$data['grade']}")
                ->description($data['gradeDesc'])
                ->descriptionIcon('heroicon-m-shield-check')
                ->color($data['gradeColor']),
            Stat::make('Konversi Persentase', "{$data['percentage']}%")
                ->description('Dinas Lingkungan Hidup')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
