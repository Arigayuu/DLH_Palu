<?php

namespace App\Filament\Resources\Laporans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use App\Services\ImageCompressionService;
use Illuminate\Http\UploadedFile;

class LaporanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Laporan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nomor_tiket')
                                    ->label('Nomor Tiket')
                                    ->disabled()
                                    ->placeholder('Otomatis'),
                                TextInput::make('nomor_hp')
                                    ->label('Nomor HP')
                                    ->required()
                                    ->tel()
                                    ->disabledOn('edit'),
                                Select::make('kategori')
                                    ->label('Kategori')
                                    ->options([
                                        'Tumbang' => 'Tumbang',
                                        'Rawan' => 'Rawan',
                                        'Kabel' => 'Kabel',
                                    ])
                                    ->required()
                                    ->disabledOn('edit'),
                            ]),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Masalah')
                            ->required()
                            ->columnSpanFull()
                            ->disabledOn('edit'),
                    ]),

                Section::make('Koordinat Lokasi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->required()
                                    ->numeric()
                                    ->disabledOn('edit'),
                                TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->required()
                                    ->numeric()
                                    ->disabledOn('edit'),
                            ]),
                    ]),

                Section::make('Tindak Lanjut')
                    ->schema([
                        Select::make('status')
                            ->label('Status Laporan')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diproses' => 'Diproses',
                                'Selesai' => 'Selesai',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->default('Menunggu')
                            ->required()
                            ->live(),
                        Textarea::make('alasan_penolakan')
                            ->label('Alasan Penolakan')
                            ->required(fn ($get) => $get('status') === 'Ditolak')
                            ->visible(fn ($get) => $get('status') === 'Ditolak')
                            ->columnSpanFull(),
                        FileUpload::make('bukti_foto_selesai')
                            ->label('Bukti Foto Selesai')
                            ->image()
                            ->disk('public')
                            ->directory('laporan-selesai')
                            ->required(fn ($get) => $get('status') === 'Selesai')
                            ->visible(fn ($get) => $get('status') === 'Selesai')
                            ->columnSpanFull()
                            ->saveUploadedFileUsing(function (UploadedFile $file) {
                                $compressionService = app(ImageCompressionService::class);
                                return $compressionService->compressAndStore($file, 'laporan-selesai');
                            }),
                    ]),
            ]);
    }
}
