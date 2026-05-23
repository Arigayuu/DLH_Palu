<?php

namespace App\Filament\Resources\IkmResponses;

use App\Filament\Resources\IkmResponses\Pages\CreateIkmResponse;
use App\Filament\Resources\IkmResponses\Pages\EditIkmResponse;
use App\Filament\Resources\IkmResponses\Pages\ListIkmResponses;
use App\Filament\Resources\IkmResponses\Schemas\IkmResponseForm;
use App\Filament\Resources\IkmResponses\Tables\IkmResponsesTable;
use App\Models\IkmResponse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IkmResponseResource extends Resource
{
    protected static ?string $model = IkmResponse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Responden IKM';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return IkmResponseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IkmResponsesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIkmResponses::route('/'),
            'create' => CreateIkmResponse::route('/create'),
            'edit' => EditIkmResponse::route('/{record}/edit'),
        ];
    }
}
