<?php

namespace App\Filament\Resources\Empleados\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmpleadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('sucursal_id')
                    ->required()
                    ->numeric(),
                TextInput::make('numero_empleado'),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('apellido_paterno'),
                TextInput::make('apellido_materno'),
                TextInput::make('telefono')
                    ->tel(),
                TextInput::make('puesto'),
                DatePicker::make('fecha_ingreso'),
                Select::make('estatus')
                    ->options(['ACTIVO' => 'A c t i v o', 'INACTIVO' => 'I n a c t i v o', 'BAJA' => 'B a j a'])
                    ->default('ACTIVO')
                    ->required(),
                TextInput::make('meta_ventas_mensual')
                    ->numeric(),
            ]);
    }
}
