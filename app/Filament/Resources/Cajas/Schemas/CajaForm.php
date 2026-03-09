<?php

namespace App\Filament\Resources\Cajas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CajaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sucursal_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('clave')
                    ->required(),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
