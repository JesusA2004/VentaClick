<?php

namespace App\Filament\Resources\CajaTurnos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CajaTurnosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('caja_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fecha_apertura')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_cierre')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('monto_inicial')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('monto_ventas_brutas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('monto_descuentos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('monto_final_calculado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('monto_final_declarado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('diferencia')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado')
                    ->badge(),
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
