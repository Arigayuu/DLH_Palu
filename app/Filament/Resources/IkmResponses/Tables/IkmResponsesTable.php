<?php

namespace App\Filament\Resources\IkmResponses\Tables;

use App\Exports\IkmResponseExport;
use App\Models\IkmResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Actions\ViewAction;

class IkmResponsesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
                TextColumn::make('indikator_1')
                    ->label('I1')
                    ->alignCenter(),
                TextColumn::make('indikator_2')
                    ->label('I2')
                    ->alignCenter(),
                TextColumn::make('indikator_3')
                    ->label('I3')
                    ->alignCenter(),
                TextColumn::make('indikator_4')
                    ->label('I4')
                    ->alignCenter(),
                TextColumn::make('indikator_5')
                    ->label('I5')
                    ->alignCenter(),
                TextColumn::make('indikator_6')
                    ->label('I6')
                    ->alignCenter(),
                TextColumn::make('indikator_7')
                    ->label('I7')
                    ->alignCenter(),
                TextColumn::make('nilai_rata_rata')
                    ->label('Rata-rata')
                    ->state(fn ($record) => number_format($record->nilai_rata_rata, 2))
                    ->alignCenter()
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw('(indikator_1 + indikator_2 + indikator_3 + indikator_4 + indikator_5 + indikator_6 + indikator_7) / 7.0 ' . $direction);
                    }),
                TextColumn::make('saran')
                    ->label('Saran')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('-'),
            ])
            ->headerActions([
                Action::make('exportExcel')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(fn () => Excel::download(new IkmResponseExport, 'ikm-survei-' . now()->format('Y-m-d') . '.xlsx')),
                Action::make('exportPdf')
                    ->label('Ekspor PDF')
                    ->color('danger')
                    ->icon('heroicon-o-document-text')
                    ->action(function () {
                        $items = IkmResponse::latest()->get();
                        $average = $items->isEmpty() ? 0 : ($items->sum(fn ($i) => $i->nilai_rata_rata) / $items->count());
                        $pdf = Pdf::loadView('pdf.ikm-report', compact('items', 'average'));
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'laporan-ikm-' . now()->format('Y-m-d') . '.pdf'
                        );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
