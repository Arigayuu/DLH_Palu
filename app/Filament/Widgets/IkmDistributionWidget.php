<?php

namespace App\Filament\Widgets;

use App\Models\IkmResponse;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Livewire\Attributes\Reactive;
use Filament\Tables\Columns\TextColumn;

class IkmDistributionWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Distribusi Responden per Indikator';

    #[Reactive]
    public array $pageFilters = [];

    public function table(Table $table): Table
    {
        $year = $this->pageFilters['selectedYear'] ?? date('Y');
        $month = $this->pageFilters['selectedMonth'] ?? 'all';

        $queries = [];
        $indicators = [
            1 => 'Persyaratan',
            2 => 'Prosedur',
            3 => 'Waktu Layanan',
            4 => 'Biaya/Tarif',
            5 => 'Spesifikasi Produk',
            6 => 'Kompetensi Petugas',
            7 => 'Penanganan Pengaduan',
        ];

        foreach ($indicators as $i => $name) {
            $q = IkmResponse::query();
            if ($year) {
                $q->whereYear('created_at', $year);
            }
            if ($month && $month !== 'all') {
                $q->whereMonth('created_at', $month);
            }
            $q->selectRaw("
                {$i} as id,
                '{$name}' as nama,
                SUM(CASE WHEN indikator_{$i} = 1 THEN 1 ELSE 0 END) as buruk,
                SUM(CASE WHEN indikator_{$i} = 2 THEN 1 ELSE 0 END) as cukup,
                SUM(CASE WHEN indikator_{$i} = 3 THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN indikator_{$i} = 4 THEN 1 ELSE 0 END) as sangat_baik
            ");
            $queries[] = $q;
        }

        $baseQuery = array_shift($queries);
        foreach ($queries as $q) {
            $baseQuery->unionAll($q);
        }

        return $table
            ->query(IkmResponse::query()->fromSub($baseQuery, 'ikm_responses'))
            ->defaultSort('id')
            ->paginated(false)
            ->columns([
                TextColumn::make('nama')
                    ->label('Unsur Pelayanan')
                    ->weight('semibold'),
                    
                TextColumn::make('buruk')
                    ->label('Buruk (1)')
                    ->alignCenter()
                    ->badge(fn ($state) => $state > 0)
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),
                    
                TextColumn::make('cukup')
                    ->label('Cukup (2)')
                    ->alignCenter()
                    ->badge(fn ($state) => $state > 0)
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'gray'),
                    
                TextColumn::make('baik')
                    ->label('Baik (3)')
                    ->alignCenter()
                    ->badge(fn ($state) => $state > 0)
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
                    
                TextColumn::make('sangat_baik')
                    ->label('Sangat Baik (4)')
                    ->alignCenter()
                    ->badge(fn ($state) => $state > 0)
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
            ]);
    }
}
