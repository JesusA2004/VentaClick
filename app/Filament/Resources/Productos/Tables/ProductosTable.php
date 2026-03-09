<?php

namespace App\Filament\Resources\Productos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('categoria_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('codigo_barras')
                    ->searchable(),
                TextColumn::make('codigo_qr')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('precio_compra')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('precio_venta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('impuesto_porcentaje')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('permite_descuento')
                    ->boolean(),
                TextColumn::make('stock_minimo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unidad_medida')
                    ->searchable(),
                IconColumn::make('activo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
