<?php

namespace App\Filament\Resources\Descuentos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DescuentosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->badge(),
                TextColumn::make('valor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fecha_inicio')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('fecha_fin')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('limite_usos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('usos_actuales')
                    ->numeric()
                    ->sortable(),
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
