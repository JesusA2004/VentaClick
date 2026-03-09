<?php

namespace App\Filament\Resources\Descuentos\Pages;

use App\Filament\Resources\Descuentos\DescuentoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDescuento extends EditRecord
{
    protected static string $resource = DescuentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
