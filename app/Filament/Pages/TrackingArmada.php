<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TrackingArmada extends Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = '/tracking-armada';

    protected static ?int $navigationSort = 1;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $title = 'Pelacakan Armada';

    protected static ?string $navigationLabel = 'Pelacakan Armada';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('search')
                ->label('Cari Armada')
                ->placeholder('Nama atau IMEI...')
                ->live(debounce: 300),
            Select::make('statusFilter')
                ->label('Status')
                ->options([
                    'all' => 'Semua Status',
                    'aktif' => 'Aktif (Mesin On)',
                    'parkir' => 'Parkir (Mesin Off)',
                ])
                ->default('all')
                ->live(),
        ]);
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\TrackingStatsWidget::class,
            \App\Filament\Widgets\TrackingMapWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
