<?php

namespace App\Filament\Resources\IkmResponses\Pages;

use App\Filament\Resources\IkmResponses\IkmResponseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIkmResponses extends ListRecords
{
    protected static string $resource = IkmResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
