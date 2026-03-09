<?php

namespace App\Filament\Resources\CajaTurnos\Pages;

use App\Filament\Resources\CajaTurnos\CajaTurnoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCajaTurnos extends ListRecords
{
    protected static string $resource = CajaTurnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
