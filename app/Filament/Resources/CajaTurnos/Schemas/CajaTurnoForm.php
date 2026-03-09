<?php

namespace App\Filament\Resources\CajaTurnos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CajaTurnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('caja_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('fecha_apertura')
                    ->required(),
                DateTimePicker::make('fecha_cierre'),
                TextInput::make('monto_inicial')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('monto_ventas_brutas')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('monto_descuentos')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('monto_final_calculado')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('monto_final_declarado')
                    ->numeric(),
                TextInput::make('diferencia')
                    ->numeric(),
                Select::make('estado')
                    ->options(['ABIERTO' => 'A b i e r t o', 'CERRADO' => 'C e r r a d o', 'CANCELADO' => 'C a n c e l a d o'])
                    ->default('ABIERTO')
                    ->required(),
            ]);
    }
}
