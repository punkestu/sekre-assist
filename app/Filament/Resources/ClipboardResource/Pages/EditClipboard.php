<?php

namespace App\Filament\Resources\ClipboardResource\Pages;

use App\Filament\Resources\ClipboardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

class EditClipboard extends EditRecord
{
    protected static string $resource = ClipboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CopyAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
