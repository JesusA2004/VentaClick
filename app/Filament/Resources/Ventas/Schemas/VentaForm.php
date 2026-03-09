<?php

namespace App\Filament\Resources\Ventas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sucursal_id')
                    ->required()
                    ->numeric(),
                TextInput::make('caja_id')
                    ->required()
                    ->numeric(),
                TextInput::make('caja_turno_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cliente_id')
                    ->numeric(),
                TextInput::make('descuento_id')
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('descuento_total')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('impuesto_total')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('total_pagado')
                    ->numeric(),
                TextInput::make('cambio')
                    ->numeric(),
                Select::make('estado')
                    ->options([
            'COMPLETADA' => 'C o m p l e t a d a',
            'CANCELADA' => 'C a n c e l a d a',
            'DEVUELTA' => 'D e v u e l t a',
        ])
                    ->default('COMPLETADA')
                    ->required(),
            ]);
    }
}
