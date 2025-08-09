<?php

namespace App\Filament\Resources\UndanganResource\Pages;

use App\Filament\Resources\UndanganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUndangan extends EditRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
