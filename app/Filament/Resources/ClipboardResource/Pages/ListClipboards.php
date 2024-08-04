<?php

namespace App\Filament\Resources\ClipboardResource\Pages;

use App\Filament\Resources\ClipboardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClipboards extends ListRecords
{
    protected static string $resource = ClipboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
