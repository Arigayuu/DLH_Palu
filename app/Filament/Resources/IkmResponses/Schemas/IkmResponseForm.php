<?php

namespace App\Filament\Resources\IkmResponses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class IkmResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Penilaian Responden')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('indikator_1')
                                    ->label('1. Prosedur dan Persyaratan')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_2')
                                    ->label('2. Kecepatan Waktu Petugas')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_3')
                                    ->label('3. Biaya dan Tarif')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_4')
                                    ->label('4. Kualitas Sarana & Prasarana')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_5')
                                    ->label('5. Kompetensi dan Perilaku Petugas')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_6')
                                    ->label('6. Penanganan Pengaduan')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                                Select::make('indikator_7')
                                    ->label('7. Hasil Layanan (Produk)')
                                    ->options([
                                        1 => 'Sangat Tidak Puas (1)',
                                        2 => 'Kurang Puas (2)',
                                        3 => 'Puas (3)',
                                        4 => 'Sangat Puas (4)',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('Saran & Masukan')
                    ->schema([
                        Textarea::make('saran')
                            ->label('Saran / Masukan Responden')
                            ->placeholder('Tuliskan saran di sini jika ada...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
