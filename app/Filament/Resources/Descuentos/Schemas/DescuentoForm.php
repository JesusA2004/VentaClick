<?php

namespace App\Filament\Resources\Descuentos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DescuentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo'),
                TextInput::make('nombre'),
                Select::make('tipo')
                    ->options(['PORCENTAJE' => 'P o r c e n t a j e', 'MONTO' => 'M o n t o'])
                    ->required(),
                TextInput::make('valor')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('fecha_inicio'),
                DateTimePicker::make('fecha_fin'),
                TextInput::make('limite_usos')
                    ->numeric(),
                TextInput::make('usos_actuales')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
