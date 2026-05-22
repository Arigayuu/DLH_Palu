<?php

namespace App\Filament\Pages;

use App\Models\IkmResponse;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class DashboardIkm extends Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = '/dashboard-ikm';

    protected static ?int $navigationSort = 2;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $title = 'Dashboard IKM';

    protected static ?string $navigationLabel = 'Dashboard IKM';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('selectedYear')
                ->label('Tahun')
                ->options($this->getAvailableYears())
                ->default(date('Y'))
                ->live(),
            Select::make('selectedMonth')
                ->label('Bulan')
                ->options($this->getAvailableMonths())
                ->default('all')
                ->live(),
        ]);
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\IkmStatsOverview::class,
            \App\Filament\Widgets\IkmBarChart::class,
            \App\Filament\Widgets\IkmTrendChart::class,
            \App\Filament\Widgets\IkmDistributionWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }

    public function getAvailableYears(): array
    {
        $yearsList = IkmResponse::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year', 'year')
            ->toArray();

        if (empty($yearsList)) {
            $yearsList = [date('Y') => date('Y')];
        }

        return $yearsList;
    }

    public function getAvailableMonths(): array
    {
        return [
            'all' => 'Semua Bulan',
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }
}
