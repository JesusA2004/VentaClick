<?php

namespace App\Filament\Resources\CajaTurnos\Pages;

use App\Filament\Resources\CajaTurnos\CajaTurnoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCajaTurno extends EditRecord
{
    protected static string $resource = CajaTurnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
