<?php

namespace App\Filament\Resources\CajaTurnos;

use App\Filament\Resources\CajaTurnos\Pages\CreateCajaTurno;
use App\Filament\Resources\CajaTurnos\Pages\EditCajaTurno;
use App\Filament\Resources\CajaTurnos\Pages\ListCajaTurnos;
use App\Filament\Resources\CajaTurnos\Schemas\CajaTurnoForm;
use App\Filament\Resources\CajaTurnos\Tables\CajaTurnosTable;
use App\Models\CajaTurno;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CajaTurnoResource extends Resource
{
    protected static ?string $model = CajaTurno::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return CajaTurnoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CajaTurnosTable::configure($table);
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
            'index' => ListCajaTurnos::route('/'),
            'create' => CreateCajaTurno::route('/create'),
            'edit' => EditCajaTurno::route('/{record}/edit'),
        ];
    }
}
