<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('categoria_id')
                    ->numeric(),
                TextInput::make('codigo_barras'),
                TextInput::make('codigo_qr'),
                TextInput::make('sku')
                    ->label('SKU'),
                TextInput::make('nombre')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('precio_compra')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('precio_venta')
                    ->required()
                    ->numeric(),
                TextInput::make('impuesto_porcentaje')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('permite_descuento')
                    ->required(),
                TextInput::make('stock_minimo')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('unidad_medida')
                    ->required()
                    ->default('PZA'),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
