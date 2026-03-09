<?php

namespace App\Filament\Resources\Descuentos;

use App\Filament\Resources\Descuentos\Pages\CreateDescuento;
use App\Filament\Resources\Descuentos\Pages\EditDescuento;
use App\Filament\Resources\Descuentos\Pages\ListDescuentos;
use App\Filament\Resources\Descuentos\Schemas\DescuentoForm;
use App\Filament\Resources\Descuentos\Tables\DescuentosTable;
use App\Models\Descuento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DescuentoResource extends Resource
{
    protected static ?string $model = Descuento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return DescuentoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DescuentosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDescuentos::route('/'),
            'create' => CreateDescuento::route('/create'),
            'edit' => EditDescuento::route('/{record}/edit'),
        ];
    }
}
