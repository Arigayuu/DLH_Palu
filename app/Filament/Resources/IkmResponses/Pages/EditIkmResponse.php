<?php

namespace App\Filament\Resources\IkmResponses\Pages;

use App\Filament\Resources\IkmResponses\IkmResponseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIkmResponse extends EditRecord
{
    protected static string $resource = IkmResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
