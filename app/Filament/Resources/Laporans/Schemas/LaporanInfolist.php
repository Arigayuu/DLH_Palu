<?php

namespace App\Filament\Resources\Laporans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LaporanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('nomor_tiket')
                                    ->label('Nomor Tiket'),
                                TextEntry::make('nomor_hp')
                                    ->label('Nomor HP / WhatsApp'),
                                TextEntry::make('kategori')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Tumbang' => 'danger',
                                        'Rawan' => 'warning',
                                        'Kabel' => 'info',
                                        default => 'gray',
                                    }),
                            ]),
                        TextEntry::make('deskripsi')
                            ->label('Deskripsi Masalah')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Status & Bukti Penyelesaian')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status Laporan')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Menunggu' => 'gray',
                                        'Diproses' => 'warning',
                                        'Selesai' => 'success',
                                        'Ditolak' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('alasan_penolakan')
                                    ->label('Alasan Penolakan')
                                    ->visible(fn ($record) => $record && $record->status === 'Ditolak')
                                    ->placeholder('-'),
                            ]),
                        ImageEntry::make('bukti_foto_selesai')
                            ->label('Foto Bukti Selesai')
                            ->disk('public')
                            ->visible(fn ($record) => $record && $record->status === 'Selesai' && $record->bukti_foto_selesai)
                            ->placeholder('-'),
                    ])
                    ->collapsible(),

                Section::make('Foto Pendukung')
                    ->schema([
                        ImageEntry::make('fotos.path_foto')
                            ->label('Foto Kejadian')
                            ->disk('public')
                            ->placeholder('Tidak ada foto pendukung.'),
                    ])
                    ->collapsible(),

                Section::make('Lokasi Kejadian')
                    ->schema([
                        ViewEntry::make('lokasi_map')
                            ->label('Peta Lokasi')
                            ->view('filament.components.map-infolist'),
                    ])
                    ->collapsible(),
            ]);
    }
}
